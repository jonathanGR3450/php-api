<?php

declare(strict_types=1);

namespace Api\Payments\Userinterface\Controller;

use Api\Payments\Application\UseCase\DeletePaymentsUseCase;
use Api\Shared\UserInterface\BaseController;

class DeletePaymentsController extends BaseController
{
    private DeletePaymentsUseCase $deletePaymentsUseCase;
    private string $id;
    private string $id2;
    public function __construct(DeletePaymentsUseCase $deletePaymentsUseCase, string $id, string $id2)
    {
        $this->deletePaymentsUseCase = $deletePaymentsUseCase;
        $this->id = $id;
        $this->id2 = $id2;
    }

    public function __invoke()
    {
        try {
            $this->deletePaymentsUseCase->__invoke(
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
