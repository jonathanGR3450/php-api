<?php

namespace Api\Orders\Userinterface\Controller\OrderDetail;

use Api\Orders\Application\UseCase\OrderDetail\CreateOrderDetailUseCase;
use Api\Orders\Userinterface\Requests\OrderDetailFormRequest;
use Api\Shared\UserInterface\BaseController;

class CreateOrderDetailController extends BaseController
{
    private CreateOrderDetailUseCase $createOrderDetailUseCase;
    public function __construct(CreateOrderDetailUseCase $createOrderDetailUseCase)
    {
        $this->createOrderDetailUseCase = $createOrderDetailUseCase;
    }

    public function __invoke()
    {
        $validator = new OrderDetailFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->createOrderDetailUseCase->__invoke(
                $this->queryPost('orderNumber', null),
                $this->queryPost('productCode', null),
                $this->queryPost('quantityOrdered', null),
                $this->queryPost('priceEach', null),
                $this->queryPost('orderLineNumber', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'create order detail successfull',
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
