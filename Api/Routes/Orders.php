<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Orders\Application\UseCase\CreateOrderUseCase;
use Api\Orders\Application\UseCase\DeleteOrderUseCase;
use Api\Orders\Application\UseCase\IndexOrderUseCase;
use Api\Orders\Application\UseCase\UpdateOrderUseCase;
use Api\Orders\Infrastructure\Models\OrdersModel;
use Api\Orders\Infrastructure\OrdersRepository;
use Api\Orders\Userinterface\Controller\CreateOrderController;
use Api\Orders\Userinterface\Controller\DeleteOrderController;
use Api\Orders\Userinterface\Controller\GetOrdersController;
use Api\Orders\Userinterface\Controller\UpdateOrderController;

class Orders extends Routes
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
                $controller = new GetOrdersController(
                    new IndexOrderUseCase(
                        new OrdersRepository(
                            new OrdersModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'POST':
                $controller = new CreateOrderController(
                    new CreateOrderUseCase(
                        new OrdersRepository(
                            new OrdersModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'PUT':
                $this->validateId();
                $controller = new UpdateOrderController(
                    new UpdateOrderUseCase(
                        new OrdersRepository(
                            new OrdersModel()
                        )
                    ),
                    $this->id
                );
                $controller->__invoke();
                break;

            case 'DELETE':
                $this->validateId();
                $controller = new DeleteOrderController(
                    new DeleteOrderUseCase(
                        new OrdersRepository(
                            new OrdersModel()
                        )
                    ),
                    $this->id
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
