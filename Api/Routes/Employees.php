<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Employees\Application\UseCase\IndexEmployeesUseCase;
use Api\Employees\Infrastructure\Models\EmployeesModel;
use Api\Employees\Infrastructure\EmployeesRepository;
use Api\Employees\Userinterface\Controller\GetEmployeesController;

class Employees extends Routes
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
                $controller = new GetEmployeesController(
                    new IndexEmployeesUseCase(
                        new EmployeesRepository(
                            new EmployeesModel()
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
