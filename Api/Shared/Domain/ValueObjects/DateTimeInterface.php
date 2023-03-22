<?php

declare(strict_types=1);

namespace Api\Shared\Domain\ValueObjects;

interface DateTimeInterface
{
    public const DATETIME_FORMAT = 'Y-m-d';
    public const DATETIME_ZONE = 'UTC';

    public function value(): string;

    public static function fromPrimitives(string $datetime): static;

}