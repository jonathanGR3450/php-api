<?php

namespace Api\Payments\Userinterface\Controller;

use Api\Payments\Application\UseCase\IndexPaymentsUseCase;
use Api\Shared\UserInterface\BaseController;

class GetPaymentsController extends BaseController
{
    private IndexPaymentsUseCase $indexPaymentsUseCase;
    public function __construct(IndexPaymentsUseCase $indexPaymentsUseCase)
    {
        $this->indexPaymentsUseCase = $indexPaymentsUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexPaymentsUseCase->__invoke(
                $this->queryGet('offset', null),
                (int) $this->queryGet('customerNumber', null),
                $this->queryGet('checkNumber', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'Get all orders detail successfull',
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
