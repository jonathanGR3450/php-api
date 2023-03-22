<?php

declare(strict_types=1);

namespace Api\Payments\Infrastructure;

use Api\Payments\Domain\Aggregate\Payments;
use Api\Payments\Domain\PaymentsRepositoryInterface;
use Api\Payments\Domain\PaymentsSearchCriteria;
use Api\Payments\Domain\ValueObjects\Amount;
use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Payments\Domain\ValueObjects\PaymentDate;
use Api\Payments\Infrastructure\Models\PaymentsModel;

class PaymentsRepository implements PaymentsRepositoryInterface
{
    private PaymentsModel $paymentsModel;

    public function __construct(PaymentsModel $paymentsModel)
    {
        $this->paymentsModel = $paymentsModel;
    }

    public function searchByCriteria(PaymentsSearchCriteria $criteria): array
    {
        $query = $this->paymentsModel->select();

        if (!empty($criteria->customerNumber())) {
            $query->where('customerNumber', 'LIKE', "'%{$criteria->customerNumber()}%'");
        }

        if (!empty($criteria->checkNumber())) {
            $query->where('checkNumber', 'LIKE', "'%{$criteria->checkNumber()}%'");
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

    public function create(Payments $payments): void
    {
        $this->paymentsModel->create($payments->asArray());
    }

    public function getNextId(): int
    {
        return $this->paymentsModel->getNextId();
    }

    public function findById(CustomerNumber $customerNumber, CheckNumber $checkNumber): Payments
    {
        $order = $this->paymentsModel->getPayments($customerNumber->value(), $checkNumber->value());
        return self::map($order);
    }

    public function findByOrderNumber(OrderNumber $OrderNumber): array
    {
        $query = $this->paymentsModel->select()->where('OrderNumber', '=', $OrderNumber->value());
        return array_map(
            static fn (array $model) => self::map($model),
            $query->get()
        );
    }

    public function update(Payments $payments): void
    {
        $this->paymentsModel->update2($payments->asArray(), $payments->customerNumber()->value(), $payments->checkNumber()->value());
    }

    public function delete(Payments $payments): void
    {
        $this->paymentsModel->delete2($payments->customerNumber()->value(), $payments->checkNumber()->value());
    }

    public static function map(array $model): Payments
    {
        return Payments::create(
            CustomerNumber::fromInteger($model['customerNumber']),
            CheckNumber::fromString($model['checkNumber']),
            PaymentDate::fromPrimitives($model['paymentDate']),
            Amount::fromFloat(floatval($model['amount'])),
            !empty($model['orderNumber']) ? OrderNumber::fromInteger(intval($model['orderNumber'])) : null
        );
    }
}
