<?php

namespace Api\PaymentMethod\Application\UseCase;

use Api\PaymentMethod\Domain\Aggregate\PaymentMethod;
use Api\PaymentMethod\Domain\PaymentMethodSearchCriteria;
use Api\PaymentMethod\Infrastructure\PaymentMethodRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexPaymentMethodUseCase
{
    private PaymentMethodRepository $paymentMethodRepository;
    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function __invoke(?int $offset = null, ?string $nameMethod = null): array
    {
        $criteria = PaymentMethodSearchCriteria::create($offset, $nameMethod);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('paymentMethodNumber'), CriteriaSortDirection::ASC));
        $data = $this->paymentMethodRepository->searchByCriteria($criteria);

        return array_map(fn (PaymentMethod $paymentMethod) => $paymentMethod->asArray(), $data);
    }
}