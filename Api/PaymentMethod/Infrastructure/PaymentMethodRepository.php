<?php

declare(strict_types=1);

namespace Api\PaymentMethod\Infrastructure;

use Api\PaymentMethod\Domain\Aggregate\PaymentMethod;
use Api\PaymentMethod\Domain\PaymentMethodSearchCriteria;
use Api\PaymentMethod\Domain\PaymentMethodRepositoryInterface;
use Api\PaymentMethod\Domain\ValueObjects\DescriptioMethod;
use Api\PaymentMethod\Domain\ValueObjects\NameMethod;
use Api\PaymentMethod\Domain\ValueObjects\PaymentMethodNumber;
use Api\PaymentMethod\Infrastructure\Models\PaymentMethodModel;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface
{
    private PaymentMethodModel $paymentMethodModel;

    public function __construct(PaymentMethodModel $paymentMethodModel)
    {
        $this->paymentMethodModel = $paymentMethodModel;
    }

    public function searchByCriteria(PaymentMethodSearchCriteria $criteria): array
    {
        $query = $this->paymentMethodModel->select();

        if (!empty($criteria->nameMethod())) {
            $query->where('nameMethod', 'LIKE', "'%{$criteria->nameMethod()}%'");
        }
        if ($criteria->pagination() !== null) {
            $query->limit(
                $criteria->pagination()->limit()->value(),
                $criteria->pagination()->offset()->value()
            );
        }


        return array_map(
            static fn (array $model) => self::map($model),
            $query->get()
        );
    }

    public function create(PaymentMethod $paymentMethod): void
    {
        $this->paymentMethodModel->create($paymentMethod->asArray());
    }

    public function getNextId(): int
    {
        return $this->paymentMethodModel->getNextId();
    }

    public function findById(PaymentMethodNumber $paymentMethodNumber): PaymentMethod
    {
        $paymentMethod = $this->paymentMethodModel->findById($paymentMethodNumber->value());
        return self::map($paymentMethod);
    }

    public function update(PaymentMethod $paymentMethod): void
    {
        $this->paymentMethodModel->update($paymentMethod->asArray(), $paymentMethod->paymentMethodNumber()->value());
    }

    public function delete(PaymentMethod $paymentMethod): void
    {
        $this->paymentMethodModel->delete($paymentMethod->paymentMethodNumber()->value());
    }

    public static function map(array $model): PaymentMethod
    {
        return PaymentMethod::create(
            PaymentMethodNumber::fromInteger($model['paymentMethodNumber']),
            NameMethod::fromString($model['nameMethod']),
            !empty($model['descriptioMethod']) ? DescriptioMethod::fromString($model['descriptioMethod']) : null
        );
    }
}
