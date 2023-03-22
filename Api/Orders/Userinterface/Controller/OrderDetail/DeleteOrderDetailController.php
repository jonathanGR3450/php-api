<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Controller\OrderDetail;

use Api\Orders\Application\UseCase\OrderDetail\DeleteOrderDetailUseCase;
use Api\Shared\UserInterface\BaseController;

class DeleteOrderDetailController extends BaseController
{
    private DeleteOrderDetailUseCase $deleteOrderDetailUseCase;
    private string $id;
    private string $id2;
    public function __construct(DeleteOrderDetailUseCase $deleteOrderDetailUseCase, string $id, string $id2)
    {
        $this->deleteOrderDetailUseCase = $deleteOrderDetailUseCase;
        $this->id = $id;
        $this->id2 = $id2;
    }

    public function __invoke()
    {
        try {
            $this->deleteOrderDetailUseCase->__invoke(
                $this->id,
                $this->id2
            );

            $data = [
                'status' => 'success',
                'message' => 'delete order detail successfull',
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
