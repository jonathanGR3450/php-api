<?php

namespace Api\PaymentMethod\Userinterface\Controller;

use Api\PaymentMethod\Application\UseCase\IndexPaymentMethodUseCase;
use Api\Shared\UserInterface\BaseController;

class GetPaymentMethodController extends BaseController
{
    private IndexPaymentMethodUseCase $indexPaymentMethodUseCase;
    public function __construct(IndexPaymentMethodUseCase $indexPaymentMethodUseCase)
    {
        $this->indexPaymentMethodUseCase = $indexPaymentMethodUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexPaymentMethodUseCase->__invoke(
                $this->queryGet('offset', null),
                $this->queryGet('nameMethod', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'Get all payment methods successfull',
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
