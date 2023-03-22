<?php

declare(strict_types=1);

namespace Api\Orders\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class OrderSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?int $orderNumber = null;
    private ?int $customerNumber = null;
    private ?string $status = null;

    public static function create(?int $offset = null, ?int $orderNumber = null, ?int $customerNumber = null, ?string $status = null): OrderSearchCriteria
    {
        if (empty($offset)) {
            $criteria = new self();
        } else {
            $criteria = new self(
                CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
            );
        }

        if (!empty($orderNumber)) {
            $criteria->orderNumber = $orderNumber;
        }

        if (!empty($customerNumber)) {
            $criteria->customerNumber = $customerNumber;
        }

        if (!empty($status)) {
            $criteria->status = $status;
        }

        return $criteria;
    }

    public function orderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function customerNumber(): ?int
    {
        return $this->customerNumber;
    }

    public function status(): ?string
    {
        return $this->status;
    }
}
