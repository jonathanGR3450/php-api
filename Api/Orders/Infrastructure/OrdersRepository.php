<?php

declare(strict_types=1);

namespace Api\Orders\Infrastructure;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\OrderSearchCriteria;
use Api\Orders\Domain\OrdersRepositoryInterface;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\Comments;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\OrderDate;
use Api\Orders\Domain\ValueObjects\RequiredDate;
use Api\Orders\Domain\ValueObjects\ShippedDate;
use Api\Orders\Domain\ValueObjects\Status;
use Api\Orders\Infrastructure\Models\OrdersModel;

class OrdersRepository implements OrdersRepositoryInterface
{
    private OrdersModel $ordersModel;

    public function __construct(OrdersModel $ordersModel)
    {
        $this->ordersModel = $ordersModel;
    }

    public function searchByCriteria(OrderSearchCriteria $criteria): array
    {
        $query = $this->ordersModel->select();

        if (!empty($criteria->orderNumber())) {
            $query->where('orderNumber', 'LIKE', "'%{$criteria->orderNumber()}%'");
        }

        if (!empty($criteria->customerNumber())) {
            $query->where('customerNumber', 'LIKE', "'%{$criteria->customerNumber()}%'");
        }

        if (!empty($criteria->status())) {
            $query->where('status', 'LIKE', "'%{$criteria->status()}%'");
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

    public function create(Order $order): void
    {
        $this->ordersModel->create($order->asArray());
    }

    public function getNextId(): int
    {
        return $this->ordersModel->getNextId();
    }

    public function findById(OrderNumber $orderNumber): Order
    {
        $order = $this->ordersModel->findById($orderNumber->value());
        return self::map($order);
    }

    public function update(Order $order): void
    {
        $this->ordersModel->update($order->asArray(), $order->orderNumber()->value());
    }

    public function delete(Order $order): void
    {
        $this->ordersModel->delete($order->orderNumber()->value());
    }

    public static function map(array $model): Order
    {
        return Order::create(
            OrderNumber::fromInteger($model['orderNumber']),
            OrderDate::fromPrimitives($model['orderDate']),
            RequiredDate::fromPrimitives($model['requiredDate']),
            Status::fromString($model['status']),
            CustomerNumber::fromInteger($model['customerNumber']),
            !empty($model['shippedDate']) ? ShippedDate::fromPrimitives($model['shippedDate']) : null,
            !empty($model['comments']) ? Comments::fromString($model['comments']) : null,
        );
    }
}
