<?php

declare(strict_types=1);

namespace Api\Customers\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class CustomerSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?int $customerNumber = null;
    private ?string $contactLastName = null;
    private ?string $contactFirstName = null;

    public static function create(?int $offset = null, ?int $customerNumber = null, ?string $contactLastName = null, ?string $contactFirstName = null): CustomerSearchCriteria
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

        if (!empty($contactLastName)) {
            $criteria->contactLastName = $contactLastName;
        }

        if (!empty($contactFirstName)) {
            $criteria->contactFirstName = $contactFirstName;
        }

        return $criteria;
    }

    public function customerNumber(): ?int
    {
        return $this->customerNumber;
    }

    public function contactLastName(): ?string
    {
        return $this->contactLastName;
    }

    public function contactFirstName(): ?string
    {
        return $this->contactFirstName;
    }

}