<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Requests;

use Api\Shared\UserInterface\Utils\Validator;

class OrderDetailFormRequest extends Validator
{
    // isDate
    public function __construct(array $data) {
        $this->fields = [
            'orderNumber' => ['isRequired'],
            'productCode' => ['isRequired'],
            'quantityOrdered' => ['isRequired', 'isInteger'],
            'priceEach' => ['isRequired', 'isFloat'],
            'orderLineNumber' => ['isRequired', 'isInteger'],
        ];
        $this->data = $data;
    }
}
