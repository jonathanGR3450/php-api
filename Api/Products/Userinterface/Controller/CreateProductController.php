<?php

namespace Api\Products\Userinterface\Controller;

use Api\Products\Application\UseCase\CreateProductUseCase;
use Api\Shared\UserInterface\BaseController;
use Api\Products\Userinterface\Requests\ProductFormRequest;

class CreateProductController extends BaseController
{
    private CreateProductUseCase $createProductUseCase;
    public function __construct(CreateProductUseCase $createProductUseCase)
    {
        $this->createProductUseCase = $createProductUseCase;
    }

    public function __invoke()
    {
        $validator = new ProductFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->createProductUseCase->__invoke(
                $this->queryPost('productCode', null),
                $this->queryPost('productName', null),
                $this->queryPost('productLine', null),
                $this->queryPost('productScale', null),
                $this->queryPost('productVendor', null),
                $this->queryPost('productDescription', null),
                $this->queryPost('quantityInStock', null),
                $this->queryPost('buyPrice', null),
                $this->queryPost('msrp', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'create product successfull',
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
