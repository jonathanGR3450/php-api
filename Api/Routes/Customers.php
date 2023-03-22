<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Customers\Application\UseCase\CreateUseCase;
use Api\Customers\Application\UseCase\DeleteUseCase;
use Api\Customers\Application\UseCase\IndexUseCase;
use Api\Customers\Application\UseCase\UpdateUseCase;
use Api\Customers\Infrastructure\CustomersRepository;
use Api\Customers\Infrastructure\Models\CustomersModel;
use Api\Customers\Userinterface\Controller\CreateCustomerController;
use Api\Customers\Userinterface\Controller\DeleteCustomerController;
use Api\Customers\Userinterface\Controller\GetCustomersController;
use Api\Customers\Userinterface\Controller\UpdateCustomerController;

class Customers extends Routes
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
                $controller = new GetCustomersController(
                    new IndexUseCase(
                        new CustomersRepository(
                            new CustomersModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'POST':
                $controller = new CreateCustomerController(
                    new CreateUseCase(
                        new CustomersRepository(
                            new CustomersModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'PUT':
                $this->validateId();
                $controller = new UpdateCustomerController(
                    new UpdateUseCase(
                        new CustomersRepository(
                            new CustomersModel()
                        )
                    ),
                    $this->id
                );
                $controller->__invoke();
                break;

            case 'DELETE':
                $this->validateId();
                $controller = new DeleteCustomerController(
                    new DeleteUseCase(
                        new CustomersRepository(
                            new CustomersModel()
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
