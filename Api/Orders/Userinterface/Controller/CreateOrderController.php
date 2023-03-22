<?php

namespace Api\Orders\Userinterface\Controller;

use Api\Orders\Application\UseCase\CreateOrderUseCase;
use Api\Shared\UserInterface\BaseController;
use Api\Orders\Userinterface\Requests\OrderFormRequest;

class CreateOrderController extends BaseController
{
    private CreateOrderUseCase $createOrderUseCase;
    public function __construct(CreateOrderUseCase $createOrderUseCase)
    {
        $this->createOrderUseCase = $createOrderUseCase;
    }

    public function __invoke()
    {
        $validator = new OrderFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->createOrderUseCase->__invoke(
                $this->queryPost('orderDate', null),
                $this->queryPost('requiredDate', null),
                $this->queryPost('status', null),
                $this->queryPost('customerNumber', null),
                $this->queryPost('shippedDate', null),
                $this->queryPost('comments', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'create order successfull',
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
