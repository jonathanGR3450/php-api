<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Routes\Customers;
use Api\Shared\Domain\Exception\DomainException;

class Routes
{
    protected string $route;
    protected array $segments;
    protected string $method;
    protected mixed $id;
    protected mixed $id2;

    protected function __construct()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Credentials: true');
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }

        // Obtener la ruta de la solicitud actual
        $this->route = $_SERVER['REQUEST_URI'];
        // Eliminar los parámetros de la consulta (si existen)
        $this->route = strtok($this->route, '?');
        // Eliminar las barras diagonales iniciales y finales
        $this->route = trim($this->route, '/');
        // Separar la ruta en segmentos
        $this->segments = explode('/', $this->route);
        // Obtener el método de la solicitud actual
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->id = empty($this->segments[1]) ? null : $this->segments[1];
        $this->id2 = empty($this->segments[2]) ? null : $this->segments[2];
    }

    public static function create(): self
    {
        try {
            $me = new self();
            $me->getAllRoutes();
            return $me;
        } catch (\Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            header('Content-Type: application/json');
            $json = json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            echo $json;
            exit();
        }
    }

    final public function validateId(): void
    {
        if (empty($this->id)) {
            throw new DomainException("Id is required");
        }
    }

    final public function validateId2(): void
    {
        if (empty($this->id2)) {
            throw new DomainException("Id2 is required");
        }
    }

    private function getAllRoutes(): void
    {
        // Llamar a la función correspondiente
        switch ($this->segments[0]) {
            case 'customers':
                $routesCustomers = Customers::create();
                $routesCustomers->getRoutes();
                break;
            case 'products':
                $routesCustomers = Products::create();
                $routesCustomers->getRoutes();
                break;
            case 'orders':
                $routesOrders = Orders::create();
                $routesOrders->getRoutes();
                break;
            case 'ordersdetail':
                $routesOrdersDetail = OrdersDetail::create();
                $routesOrdersDetail->getRoutes();
                break;
            case 'payments':
                $routesPayments = Payments::create();
                $routesPayments->getRoutes();
                break;
            case 'paymentmethod':
                $routesPaymentMethod = PaymentMethod::create();
                $routesPaymentMethod->getRoutes();
                break;
            case 'orderpdf':
                $routesOrderPdf = OrderPdf::create();
                $routesOrderPdf->getRoutes();
                break;
            case 'paymentpdf':
                $routesPaymentPdf = PaymentPdf::create();
                $routesPaymentPdf->getRoutes();
                break;
            case 'employees':
                $routesEmployees = Employees::create();
                $routesEmployees->getRoutes();
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                header('Content-Type: application/json');
                $json = json_encode([
                    'status' => 'error',
                    'message' => 'page not found'
                ]);
                echo $json;
                exit();
                break;
        }
    }
}

$routes = Routes::create();
