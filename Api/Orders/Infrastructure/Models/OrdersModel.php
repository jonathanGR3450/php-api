<?php

namespace Api\Orders\Infrastructure\Models;

use Api\Shared\Infrastructure\Models\Database;

class OrdersModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'orders';
        $this->pk = 'orderNumber';
    }

    public function getOrders()
    {
        return $this->query("SELECT * FROM $this->table ORDER BY orderNumber ASC LIMIT ?", ["i", 10]);
    }

}
