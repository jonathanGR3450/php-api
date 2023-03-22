<?php

namespace Api\Customers\Domain;

use Api\Customers\Domain\Aggregate\Customer;
use Api\Customers\Domain\ValueObjects\CustomerNumber;

interface CustomersRepositoryInterface
{
    public function searchByCriteria(CustomerSearchCriteria $customerSearchCriteria): array;

    public function create(Customer $customer): void;

    public function findById(CustomerNumber $customerNumber): Customer;

    public function update(Customer $customer): void;

    public function delete(Customer $customer): void;
}
