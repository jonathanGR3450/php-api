<?php

namespace Api\PaymentMethod\Infrastructure\Models;

use Api\Shared\Infrastructure\Models\Database;

class PaymentMethodModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'paymentmethod';
        $this->pk = 'paymentMethodNumber';
    }

    public function getPaymentMethod()
    {
        return $this->query("SELECT * FROM $this->table ORDER BY paymentMethodNumber ASC LIMIT ?", ["i", 10]);
    }

}
