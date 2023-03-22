<?php

namespace Api\Payments\Application\UseCase;

use Api\Payments\Domain\Aggregate\Payments;
use Api\Payments\Domain\PaymentsSearchCriteria;
use Api\Payments\Infrastructure\PaymentsRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexPaymentsUseCase
{
    private PaymentsRepository $paymentsRepository;
    public function __construct(PaymentsRepository $paymentsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
    }

    public function __invoke(?int $offset = null, ?int $customerNumber = null, ?string $checkNumber = null): array
    {
        $criteria = PaymentsSearchCriteria::create($offset, $customerNumber, $checkNumber);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('customerNumber'), CriteriaSortDirection::DESC));
        $data = $this->paymentsRepository->searchByCriteria($criteria);

        return array_map(fn (Payments $payments) => $payments->asArray(), $data);
    }
}