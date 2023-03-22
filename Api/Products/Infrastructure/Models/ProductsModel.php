<?php

namespace Api\Products\Infrastructure\Models;

use Api\Shared\Infrastructure\Models\Database;

class ProductsModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'products';
        $this->pk = 'productCode';
    }

    public function getProducts()
    {
        return $this->query("SELECT * FROM $this->table ORDER BY productCode ASC LIMIT ?", ["i", 10]);
    }

}
