<?php

namespace Api\Orders\Userinterface\Controller\OrderDetail;

use Api\Orders\Application\UseCase\OrderDetail\IndexOrderDetailUseCase;
use Api\Shared\UserInterface\BaseController;

class GetOrdersDetailController extends BaseController
{
    private IndexOrderDetailUseCase $indexOrderDetailUseCase;
    public function __construct(IndexOrderDetailUseCase $indexOrderDetailUseCase)
    {
        $this->indexOrderDetailUseCase = $indexOrderDetailUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexOrderDetailUseCase->__invoke(
                $this->queryGet('offset', null),
                $this->queryGet('orderNumber', null),
                $this->queryGet('productCode', null)
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
