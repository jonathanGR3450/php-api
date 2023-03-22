<?php

namespace Api\Customers\Infrastructure\Models;

use Api\Shared\Infrastructure\Models\Database;

class CustomersModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'customers';
        $this->pk = 'customerNumber';
    }

    public function getCustomers()
    {
        return $this->query("SELECT * FROM $this->table ORDER BY customerNumber ASC LIMIT ?", ["i", 10]);
    }

}
