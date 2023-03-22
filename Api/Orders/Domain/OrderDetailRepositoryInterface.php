<?php

namespace Api\Orders\Domain;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\Aggregate\OrderDetail;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\OrderDetail\ProductCode;

interface OrderDetailRepositoryInterface
{
    public function searchByCriteria(OrderDetailSearchCriteria $orderDetailSearchCriteria): array;

    public function create(OrderDetail $orderDetail): void;

    public function findByOrderProduct(OrderNumber $orderNumber, ProductCode $productCode): OrderDetail;

    public function findByOrder(Order $order): array;

    public function update(OrderDetail $orderDetail): void;

    public function delete(OrderDetail $orderDetail): void;
}
