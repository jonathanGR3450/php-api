<?php

declare(strict_types=1);

namespace Api\Routes;

use Api\Products\Application\UseCase\CreateProductUseCase;
use Api\Products\Application\UseCase\DeleteProductUseCase;
use Api\Products\Application\UseCase\IndexProductsUseCase;
use Api\Products\Application\UseCase\UpdateProductUseCase;
use Api\Products\Infrastructure\ProductsRepository;
use Api\Products\Infrastructure\Models\ProductsModel;
use Api\Products\Userinterface\Controller\CreateProductController;
use Api\Products\Userinterface\Controller\DeleteProductController;
use Api\Products\Userinterface\Controller\GetProductsController;
use Api\Products\Userinterface\Controller\UpdateProductController;

class Products extends Routes
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
                $controller = new GetProductsController(
                    new IndexProductsUseCase(
                        new ProductsRepository(
                            new ProductsModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'POST':
                $controller = new CreateProductController(
                    new CreateProductUseCase(
                        new ProductsRepository(
                            new ProductsModel()
                        )
                    )
                );
                $controller->__invoke();
                break;

            case 'PUT':
                $this->validateId();
                $controller = new UpdateProductController(
                    new UpdateProductUseCase(
                        new ProductsRepository(
                            new ProductsModel()
                        )
                    ),
                    $this->id
                );
                $controller->__invoke();
                break;

            case 'DELETE':
                $this->validateId();
                $controller = new DeleteProductController(
                    new DeleteProductUseCase(
                        new ProductsRepository(
                            new ProductsModel()
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
