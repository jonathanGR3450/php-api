<?php

namespace Api\Customers\Userinterface\Controller;

use Api\Customers\Application\UseCase\IndexUseCase;
use Api\Shared\UserInterface\BaseController;

class GetCustomersController extends BaseController
{
    private IndexUseCase $indexUseCase;
    public function __construct(IndexUseCase $indexUseCase)
    {
        $this->indexUseCase = $indexUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexUseCase->__invoke(
                $this->queryGet('offset', null),
                $this->queryGet('customerNumber', null),
                $this->queryGet('contactLastName', null),
                $this->queryGet('contactFirstName', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'Get all customers successfull',
                'data' => $data
            ];

            $this->sendOutput(
                json_encode($data),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
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
