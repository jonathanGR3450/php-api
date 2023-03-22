<?php

declare(strict_types=1);

namespace Api\Customers\Userinterface\Requests;

use Api\Shared\UserInterface\Utils\Validator;

class CustomerFormRequest extends Validator
{
    public function __construct(array $data) {
        $this->fields = [
            'customerName' => ['isRequired'],
            'contactLastName' => ['isRequired'],
            'contactFirstName' => ['isRequired'],
            'phone' => ['isRequired'],
            'addressLine1' => ['isRequired'],
            'city' => ['isRequired'],
            'country' => ['isRequired'],
            'creditLimit' => ['isRequired'],
            'addressLine2' => ['isNullable'],
            'state' => ['isNullable'],
            'postalCode' => ['isNullable'],
            'salesRepEmployeeNumber'  => ['isNullable', 'isInteger']
        ];
        $this->data = $data;
    }
}
