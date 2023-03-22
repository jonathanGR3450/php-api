<?php

declare(strict_types=1);

namespace Api\Payments\Userinterface\Controller;

use Api\Payments\Application\UseCase\UpdatePaymentsUseCase;
use Api\Payments\Userinterface\Requests\PaymentsFormRequest;
use Api\Shared\UserInterface\BaseController;

class UpdatePaymentsController extends BaseController
{
    private UpdatePaymentsUseCase $updatePaymentsUseCase;
    private string $id;
    private string $id2;
    public function __construct(UpdatePaymentsUseCase $updatePaymentsUseCase, string $id, string $id2)
    {
        $this->updatePaymentsUseCase = $updatePaymentsUseCase;
        $this->id = $id;
        $this->id2 = $id2;
    }

    public function __invoke()
    {
        $validator = new PaymentsFormRequest($this->queryAllPost());
        $validator->updateRule('customerNumber', ['isNullable', 'isInteger']);
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->updatePaymentsUseCase->__invoke(
                $this->id,
                $this->id2,
                $this->queryPost('paymentDate', null),
                $this->queryPost('amount', null),
                $this->queryPost('orderNumber', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'update payment successfull',
                'data' => $result
            ];

            $this->sendOutput(
                json_encode($data),
                array('Content-Type: application/json', 'HTTP/1.1 201 OK')
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
