<?php

namespace Api\PaymentMethod\Domain;

use Api\PaymentMethod\Domain\Aggregate\PaymentMethod;
use Api\PaymentMethod\Domain\ValueObjects\PaymentMethodNumber;

interface PaymentMethodRepositoryInterface
{
    public function searchByCriteria(PaymentMethodSearchCriteria $paymentMethodSearchCriteria): array;

    public function create(PaymentMethod $paymentMethod): void;

    public function findById(PaymentMethodNumber $paymentMethodNumber): PaymentMethod;

    public function update(PaymentMethod $paymentMethod): void;

    public function delete(PaymentMethod $paymentMethod): void;
}
