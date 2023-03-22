<?php

declare(strict_types=1);

namespace Api\Shared\Domain\Models;

enum CriteriaSortDirection: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';

    public function value(): string
    {
        return $this->value;
    }
}