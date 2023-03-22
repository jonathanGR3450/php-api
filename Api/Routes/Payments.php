<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Payments\Application\UseCase\CreatePaymentsUseCase;
use Api\Payments\Application\UseCase\DeletePaymentsUseCase;
use Api\Payments\Application\UseCase\IndexPaymentsUseCase;
use Api\Payments\Application\UseCase\UpdatePaymentsUseCase;
use Api\Payments\Infrastructure\Models\PaymentsModel;
use Api\Payments\Infrastructure\PaymentsRepository;
use Api\Payments\Userinterface\Controller\CreatePaymentsController;
use Api\Payments\Userinterface\Controller\DeletePaymentsController;
use Api\Payments\Userinterface\Controller\GetPaymentsController;
use Api\Payments\Userinterface\Controller\UpdatePaymentsController;

class Payments extends Routes
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
                $controller = new GetPaymentsController(
                    new IndexPaymentsUseCase(
                        new PaymentsRepository(
                            new PaymentsModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'POST':
                $controller = new CreatePaymentsController(
                    new CreatePaymentsUseCase(
                        new PaymentsRepository(
                            new PaymentsModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'PUT':
                $this->validateId();
                $this->validateId2();
                $controller = new UpdatePaymentsController(
                    new UpdatePaymentsUseCase(
                        new PaymentsRepository(
                            new PaymentsModel()
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
                $controller = new DeletePaymentsController(
                    new DeletePaymentsUseCase(
                        new PaymentsRepository(
                            new PaymentsModel()
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
