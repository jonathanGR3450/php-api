<?php

declare(strict_types=1);

namespace Api\Orders\Infrastructure\Models;

use Api\Shared\Domain\Exception\NotFoundException;
use Api\Shared\Infrastructure\Models\Database;

class OrderDetailModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'orderdetails';
        $this->pk = 'orderNumber';
        $this->pk2 = 'productCode';
    }

    public function getOrderDetail(int $orderNumber, string $productCode): array
    {
        $data = $this->query("SELECT * FROM $this->table WHERE orderNumber = $orderNumber AND productCode='$productCode'");
        if (count($data) == 0) {
            throw new NotFoundException("Order Detail Not Found");
        }
        return $data[0];
    }

    public function findByOrder(int $orderNumber)
    {
        return $this->select()->where('orderNumber', '=', $orderNumber)->get();
    }

}
