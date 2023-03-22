<?php

namespace Api\Orders\Domain;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\ValueObjects\OrderNumber;

interface OrdersRepositoryInterface
{
    public function searchByCriteria(OrderSearchCriteria $orderSearchCriteria): array;

    public function create(Order $order): void;

    public function findById(OrderNumber $orderNumber): Order;

    public function update(Order $order): void;

    public function delete(Order $order): void;
}
