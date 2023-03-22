<?php

declare(strict_types=1);

namespace Api\Products\Userinterface\Controller;

use Api\Products\Application\UseCase\UpdateProductUseCase;
use Api\Shared\UserInterface\BaseController;
use Api\Products\Userinterface\Requests\ProductFormRequest;

class UpdateProductController extends BaseController
{
    private UpdateProductUseCase $updateProductUseCase;
    private string $id;
    public function __construct(UpdateProductUseCase $updateProductUseCase, string $id)
    {
        $this->updateProductUseCase = $updateProductUseCase;
        $this->id = $id;
    }

    public function __invoke()
    {
        $validator = new ProductFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->updateProductUseCase->__invoke(
                $this->id,
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
                'message' => 'update product successfull',
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
