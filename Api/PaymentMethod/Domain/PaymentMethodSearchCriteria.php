<?php

declare(strict_types=1);

namespace Api\PaymentMethod\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class PaymentMethodSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?string $nameMethod = null;

    public static function create(?int $offset = null, ?string $nameMethod = null): PaymentMethodSearchCriteria
    {
        if (empty($offset)) {
            $criteria = new self();
        } else {
            $criteria = new self(
                CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
            );
        }

        if (!empty($nameMethod)) {
            $criteria->nameMethod = $nameMethod;
        }

        return $criteria;
    }

    public function nameMethod(): ?string
    {
        return $this->nameMethod;
    }

}