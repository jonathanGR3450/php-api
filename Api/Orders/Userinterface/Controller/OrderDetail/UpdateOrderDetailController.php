<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Controller\OrderDetail;

use Api\Orders\Application\UseCase\OrderDetail\UpdateOrderDetailUseCase;
use Api\Orders\Userinterface\Requests\OrderDetailFormRequest;
use Api\Shared\UserInterface\BaseController;

class UpdateOrderDetailController extends BaseController
{
    private UpdateOrderDetailUseCase $updateOrderDetailUseCase;
    private string $id;
    private string $id2;
    public function __construct(UpdateOrderDetailUseCase $updateOrderDetailUseCase, string $id, string $id2)
    {
        $this->updateOrderDetailUseCase = $updateOrderDetailUseCase;
        $this->id = $id;
        $this->id2 = $id2;
    }

    public function __invoke()
    {
        $validator = new OrderDetailFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->updateOrderDetailUseCase->__invoke(
                $this->id,
                $this->id2,
                (int)$this->queryPost('orderNumber', null),
                $this->queryPost('productCode', null),
                (int) $this->queryPost('quantityOrdered', null),
                (float) $this->queryPost('priceEach', null),
                (int) $this->queryPost('orderLineNumber', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'update order detail successfull',
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
