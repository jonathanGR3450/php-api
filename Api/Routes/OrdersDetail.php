<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Orders\Application\UseCase\OrderDetail\CreateOrderDetailUseCase;
use Api\Orders\Application\UseCase\OrderDetail\DeleteOrderDetailUseCase;
use Api\Orders\Application\UseCase\OrderDetail\IndexOrderDetailUseCase;
use Api\Orders\Application\UseCase\OrderDetail\UpdateOrderDetailUseCase;
use Api\Orders\Infrastructure\Models\OrderDetailModel;
use Api\Orders\Infrastructure\OrderDetailRepository;
use Api\Orders\Userinterface\Controller\OrderDetail\CreateOrderDetailController;
use Api\Orders\Userinterface\Controller\OrderDetail\DeleteOrderDetailController;
use Api\Orders\Userinterface\Controller\OrderDetail\GetOrdersDetailController;
use Api\Orders\Userinterface\Controller\OrderDetail\UpdateOrderDetailController;

class OrdersDetail extends Routes
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
                $controller = new GetOrdersDetailController(
                    new IndexOrderDetailUseCase(
                        new OrderDetailRepository(
                            new OrderDetailModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'POST':
                $controller = new CreateOrderDetailController(
                    new CreateOrderDetailUseCase(
                        new OrderDetailRepository(
                            new OrderDetailModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'PUT':
                $this->validateId();
                $this->validateId2();
                $controller = new UpdateOrderDetailController(
                    new UpdateOrderDetailUseCase(
                        new OrderDetailRepository(
                            new OrderDetailModel()
                        )
                    ),
                    $this->id,
                    $this->id2
                );
                $controller->__invoke();
                break;

            case 'DELETE':
                $this->validateId();
                $this->validateId2();
                $controller = new DeleteOrderDetailController(
                    new DeleteOrderDetailUseCase(
                        new OrderDetailRepository(
                            new OrderDetailModel()
                        )
                    ),
                    $this->id,
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
