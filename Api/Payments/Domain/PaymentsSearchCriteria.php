<?php

declare(strict_types=1);

namespace Api\Payments\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class PaymentsSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?int $customerNumber = null;
    private ?string $checkNumber = null;

    public static function create(?int $offset = null, ?int $customerNumber = null, ?string $checkNumber = null): PaymentsSearchCriteria
    {
        if (empty($offset)) {
            $criteria = new self();
        } else {
            $criteria = new self(
                CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
            );
        }

        if (!empty($customerNumber)) {
            $criteria->customerNumber = $customerNumber;
        }

        if (!empty($checkNumber)) {
            $criteria->checkNumber = $checkNumber;
        }

        return $criteria;
    }

    public function customerNumber(): ?int
    {
        return $this->customerNumber;
    }

    public function checkNumber(): ?string
    {
        return $this->checkNumber;
    }
}
