<?php

namespace Api\Payments\Domain;

use Api\Payments\Domain\Aggregate\Payments;
use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;

interface PaymentsRepositoryInterface
{
    public function searchByCriteria(PaymentsSearchCriteria $paymentsSearchCriteria): array;

    public function create(Payments $payments): void;

    public function findById(CustomerNumber $customerNumber, CheckNumber $checkNumber): Payments;

    public function findByOrderNumber(OrderNumber $orderNumber): array;

    public function update(Payments $payments): void;

    public function delete(Payments $payments): void;
}
