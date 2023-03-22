<?php

declare(strict_types=1);

namespace Api\Payments\Userinterface\Requests;

use Api\Shared\UserInterface\Utils\Validator;

class PaymentsFormRequest extends Validator
{
    // isDate
    public function __construct(array $data) {
        $this->fields = [
            'customerNumber' => ['isRequired', 'isInteger'],
            'paymentDate' => ['isRequired', 'isDate'],
            'amount' => ['isRequired', 'isFloat'],
            'orderNumber' => ['isNullable', 'isInteger'],
        ];
        $this->data = $data;
    }
}
