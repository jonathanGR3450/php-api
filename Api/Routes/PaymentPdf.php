<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Customers\Infrastructure\CustomersRepository;
use Api\Customers\Infrastructure\Models\CustomersModel;
use Api\Orders\Infrastructure\Models\OrderDetailModel;
use Api\Orders\Infrastructure\Models\OrdersModel;
use Api\Orders\Infrastructure\OrderDetailRepository;
use Api\Orders\Infrastructure\OrdersRepository;
use Api\Payments\Application\UseCase\PdfPaymentUseCase;
use Api\Payments\Infrastructure\Models\PaymentsModel;
use Api\Payments\Infrastructure\PaymentsRepository;
use Api\Payments\Userinterface\Controller\PdfPaymentController;
use Api\Products\Infrastructure\Models\ProductsModel;
use Api\Products\Infrastructure\ProductsRepository;

class PaymentPdf extends Routes
{
    private function __construct()
    {
        parent::__construct();
    }

    public static function create(): self
    {
        return new self();
    }

    public function getRoutes()
    {
        switch ($this->method) {
            case 'GET':
                $this->validateId();
                $this->validateId2();
                $controller = new PdfPaymentController(
                    new PdfPaymentUseCase(
                        new OrdersRepository(
                            new OrdersModel()
                        ),
                        new OrderDetailRepository(
                            new OrderDetailModel()
                        ),
                        new CustomersRepository(
                            new CustomersModel()
                        ),
                        new ProductsRepository(
                            new ProductsModel()
                        ),
                        new PaymentsRepository(
                            new PaymentsModel()
                        )
                    ),
                    (int) $this->id,
                    $this->id2
                );
                $controller->__invoke();
                break;

            default:
                header("HTTP/1.1 422 Unprocessable Entity");
                header('Content-Type: application/json');
                $json = json_encode([
                    'status' => 'error',
                    'message' => 'Method not supported'
                ]);
                echo $json;
                break;
        }
    }
}
