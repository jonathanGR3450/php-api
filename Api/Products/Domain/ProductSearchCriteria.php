<?php

declare(strict_types=1);

namespace Api\Products\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class ProductSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?string $productName = null;

    public static function create(?int $offset = null, ?string $productName = null, ?string $productLine = null, ?string $productScale = null): ProductSearchCriteria
    {
        if (empty($offset)) {
            $criteria = new self();
        } else {
            $criteria = new self(
                CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
            );
        }

        if (!empty($productName)) {
            $criteria->productName = $productName;
        }

        return $criteria;
    }

    public function productName(): ?int
    {
        return $this->productName;
    }


}