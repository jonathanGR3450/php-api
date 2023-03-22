<?php

declare(strict_types=1);

namespace Api\Orders\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class OrderDetailSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?int $orderNumber = null;
    private ?string $productCode = null;

    public static function create(?int $offset = null, ?int $orderNumber = null, ?string $productCode = null): OrderDetailSearchCriteria
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

        if (!empty($productCode)) {
            $criteria->productCode = $productCode;
        }

        return $criteria;
    }

    public function orderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function productCode(): ?string
    {
        return $this->productCode;
    }
}
