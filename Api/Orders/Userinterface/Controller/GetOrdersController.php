<?php

namespace Api\Orders\Userinterface\Controller;

use Api\Orders\Application\UseCase\IndexOrderUseCase;
use Api\Shared\UserInterface\BaseController;

class GetOrdersController extends BaseController
{
    private IndexOrderUseCase $indexOrderUseCase;
    public function __construct(IndexOrderUseCase $indexOrderUseCase)
    {
        $this->indexOrderUseCase = $indexOrderUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexOrderUseCase->__invoke(
                $this->queryGet('offset', null),
                $this->queryGet('orderNumber', null),
                $this->queryGet('customerNumber', null),
                $this->queryGet('status', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'Get all orders successfull',
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
