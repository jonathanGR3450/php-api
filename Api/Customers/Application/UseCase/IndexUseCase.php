<?php

namespace Api\Customers\Application\UseCase;

use Api\Customers\Domain\Aggregate\Customer;
use Api\Customers\Domain\CustomerSearchCriteria;
use Api\Customers\Infrastructure\CustomersRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexUseCase
{
    private CustomersRepository $customersRepository;
    public function __construct(CustomersRepository $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    public function __invoke(?int $offset = null, ?int $customerNumber = null, ?string $contactLastName = null, ?string $contactFirstName = null): array
    {
        $criteria = CustomerSearchCriteria::create($offset, $customerNumber, $contactLastName, $contactFirstName);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('customerNumber'), CriteriaSortDirection::ASC));
        $data = $this->customersRepository->searchByCriteria($criteria);

        return array_map(fn (Customer $customer) => $customer->asArray(), $data);
    }
}