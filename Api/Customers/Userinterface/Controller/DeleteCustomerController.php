<?php

declare(strict_types=1);

namespace Api\Customers\Userinterface\Controller;

use Api\Customers\Application\UseCase\DeleteUseCase;
use Api\Shared\UserInterface\BaseController;

class DeleteCustomerController extends BaseController
{
    private DeleteUseCase $deleteUseCase;
    private string $id;
    public function __construct(DeleteUseCase $deleteUseCase, string $id)
    {
        $this->deleteUseCase = $deleteUseCase;
        $this->id = $id;
    }

    public function __invoke()
    {
        try {
            $this->deleteUseCase->__invoke(
                $this->id
            );

            $data = [
                'status' => 'success',
                'message' => 'delete customer successfull',
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
