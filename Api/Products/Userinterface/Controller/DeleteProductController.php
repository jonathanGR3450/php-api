<?php

declare(strict_types=1);

namespace Api\Products\Userinterface\Controller;

use Api\Products\Application\UseCase\DeleteProductUseCase;
use Api\Shared\UserInterface\BaseController;

class DeleteProductController extends BaseController
{
    private DeleteProductUseCase $deleteProductUseCase;
    private string $id;
    public function __construct(DeleteProductUseCase $deleteProductUseCase, string $id)
    {
        $this->deleteProductUseCase = $deleteProductUseCase;
        $this->id = $id;
    }

    public function __invoke()
    {
        try {
            $this->deleteProductUseCase->__invoke(
                $this->id
            );

            $data = [
                'status' => 'success',
                'message' => 'delete product successfull',
                'data' => null
            ];

            $this->sendOutput(
                json_encode($data),
                array('Content-Type: application/json', 'HTTP/1.1 204 OK')
            );
        } catch (\Exception $e) {
            $this->sendOutput(
                json_encode(array(
                    'status' => 'error',
                    'message' => $e->getMessage().' Something went wrong! Please contact support.',
                    'data' => null
                )),
                array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error')
            );
        }
    }
}
