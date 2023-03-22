<?php

declare(strict_types=1);

namespace Api\Products\Userinterface\Requests;

use Api\Shared\UserInterface\Utils\Validator;

class ProductFormRequest extends Validator
{
    public function __construct(array $data) {
        $this->fields = [
            'productCode' => ['isRequired'],
            'productName' => ['isRequired'],
            'productLine' => ['isRequired'],
            'productScale' => ['isRequired'],
            'productVendor' => ['isRequired'],
            'productDescription' => ['isRequired'],
            'quantityInStock' => ['isRequired', 'isInteger'],
            'buyPrice' => ['isRequired', 'isFloat'],
            'msrp' => ['isNullable', 'isFloat'],
        ];
        $this->data = $data;
    }
}
