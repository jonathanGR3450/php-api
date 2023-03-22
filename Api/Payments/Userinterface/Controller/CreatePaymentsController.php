<?php

namespace Api\Payments\Userinterface\Controller;

use Api\Payments\Application\UseCase\CreatePaymentsUseCase;
use Api\Payments\Userinterface\Requests\PaymentsFormRequest;
use Api\Shared\UserInterface\BaseController;

class CreatePaymentsController extends BaseController
{
    private CreatePaymentsUseCase $createPaymentsUseCase;
    public function __construct(CreatePaymentsUseCase $createPaymentsUseCase)
    {
        $this->createPaymentsUseCase = $createPaymentsUseCase;
    }

    public function __invoke()
    {
        $validator = new PaymentsFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->createPaymentsUseCase->__invoke(
                $this->queryPost('customerNumber', null),
                $this->queryPost('paymentDate', null),
                $this->queryPost('amount', null),
                $this->queryPost('orderNumber', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'create payment successfull',
                'data' => $result
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
