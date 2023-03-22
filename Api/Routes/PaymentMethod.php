<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\PaymentMethod\Application\UseCase\IndexPaymentMethodUseCase;
use Api\PaymentMethod\Infrastructure\Models\PaymentMethodModel;
use Api\PaymentMethod\Infrastructure\PaymentMethodRepository;
use Api\PaymentMethod\Userinterface\Controller\GetPaymentMethodController;

class PaymentMethod extends Routes
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
                $controller = new GetPaymentMethodController(
                    new IndexPaymentMethodUseCase(
                        new PaymentMethodRepository(
                            new PaymentMethodModel()
                        )
                    )
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
