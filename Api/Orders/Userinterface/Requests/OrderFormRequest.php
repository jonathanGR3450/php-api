<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Requests;

use Api\Shared\UserInterface\Utils\Validator;

class OrderFormRequest extends Validator
{
    // isDate
    public function __construct(array $data) {
        $this->fields = [
            'orderDate' => ['isRequired', 'isDate'],
            'requiredDate' => ['isRequired', 'isDate'],
            'status' => ['isRequired'],
            'customerNumber' => ['isRequired'],
            'shippedDate' => ['isNullable', 'isDate'],
            'comments'  => ['isNullable']
        ];
        $this->data = $data;
    }
}
