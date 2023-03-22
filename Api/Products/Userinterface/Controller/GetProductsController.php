<?php

namespace Api\Products\Userinterface\Controller;

use Api\Products\Application\UseCase\IndexProductsUseCase;
use Api\Shared\UserInterface\BaseController;

class GetProductsController extends BaseController
{
    private IndexProductsUseCase $indexProductsUseCase;
    public function __construct(IndexProductsUseCase $indexProductsUseCase)
    {
        $this->indexProductsUseCase = $indexProductsUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexProductsUseCase->__invoke(
                $this->queryGet('offset', null),
                $this->queryGet('productName', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'Get all products successfull',
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
