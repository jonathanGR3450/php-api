<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Controller;

use Api\Orders\Application\UseCase\DeleteOrderUseCase;
use Api\Shared\UserInterface\BaseController;

class DeleteOrderController extends BaseController
{
    private DeleteOrderUseCase $deleteOrderUseCase;
    private string $id;
    public function __construct(DeleteOrderUseCase $deleteOrderUseCase, string $id)
    {
        $this->deleteOrderUseCase = $deleteOrderUseCase;
        $this->id = $id;
    }

    public function __invoke()
    {
        try {
            $this->deleteOrderUseCase->__invoke(
                $this->id
            );

            $data = [
                'status' => 'success',
                'message' => 'delete order successfull',
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
