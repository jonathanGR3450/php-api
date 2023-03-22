<?php

declare(strict_types=1);

namespace Api\Employees\Domain;

use Api\Shared\Domain\Models\Criteria;
use Api\Shared\Domain\Models\CriteriaPagination;

final class EmployeesSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?string $lastName = null;

    public static function create(?int $offset = null, ?string $lastName = null): EmployeesSearchCriteria
    {
        if (empty($offset)) {
            $criteria = new self();
        } else {
            $criteria = new self(
                CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
            );
        }

        if (!empty($lastName)) {
            $criteria->lastName = $lastName;
        }

        return $criteria;
    }

    public function lastName(): ?string
    {
        return $this->lastName;
    }

}