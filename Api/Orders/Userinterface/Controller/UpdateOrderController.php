<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Controller;

use Api\Orders\Application\UseCase\UpdateOrderUseCase;
use Api\Shared\UserInterface\BaseController;
use Api\Orders\Userinterface\Requests\OrderFormRequest;

class UpdateOrderController extends BaseController
{
    private UpdateOrderUseCase $updateOrderUseCase;
    private string $id;
    public function __construct(UpdateOrderUseCase $updateOrderUseCase, string $id)
    {
        $this->updateOrderUseCase = $updateOrderUseCase;
        $this->id = $id;
    }

    public function __invoke()
    {
        $validator = new OrderFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->updateOrderUseCase->__invoke(
                $this->id,
                $this->queryPost('orderDate', null),
                $this->queryPost('requiredDate', null),
                $this->queryPost('status', null),
                (int) $this->queryPost('customerNumber', null),
                $this->queryPost('shippedDate', null),
                $this->queryPost('comments', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'update order successfull',
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
