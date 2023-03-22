<?php

declare(strict_types=1);

namespace Api\Orders\Infrastructure;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\Aggregate\OrderDetail;
use Api\Orders\Domain\OrderDetailRepositoryInterface;
use Api\Orders\Domain\OrderDetailSearchCriteria;
use Api\Orders\Domain\ValueObjects\OrderDetail\OrderLineNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\OrderDetail\PriceEach;
use Api\Orders\Domain\ValueObjects\OrderDetail\ProductCode;
use Api\Orders\Domain\ValueObjects\OrderDetail\QuantityOrdered;
use Api\Orders\Infrastructure\Models\OrderDetailModel;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    private OrderDetailModel $orderDetailModel;

    public function __construct(OrderDetailModel $orderDetailModel)
    {
        $this->orderDetailModel = $orderDetailModel;
    }

    public function searchByCriteria(OrderDetailSearchCriteria $criteria): array
    {
        $query = $this->orderDetailModel->select();

        if (!empty($criteria->orderNumber())) {
            $query->where('orderNumber', 'LIKE', "'%{$criteria->orderNumber()}%'");
        }

        if (!empty($criteria->productCode())) {
            $query->where('productCode', 'LIKE', "'%{$criteria->productCode()}%'");
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

    public function create(OrderDetail $orderDetail): void
    {
        $this->orderDetailModel->create($orderDetail->asArray());
    }

    public function getNextId(): int
    {
        return $this->orderDetailModel->getNextId();
    }

    public function findByOrderProduct(OrderNumber $orderNumber, ProductCode $productCode): OrderDetail
    {
        $order = $this->orderDetailModel->getOrderDetail($orderNumber->value(), $productCode->value());
        return self::map($order);
    }

    public function findByOrder(Order $order): array
    {
        $data = $this->orderDetailModel->findByOrder($order->orderNumber()->value());
        return array_map(
            static fn (array $model) => self::map($model),
            $data
        );
    }

    public function update(OrderDetail $orderDetail): void
    {
        $this->orderDetailModel->update2($orderDetail->asArray(), $orderDetail->orderNumber()->value(), $orderDetail->productCode()->value());
    }

    public function delete(OrderDetail $orderDetail): void
    {
        $this->orderDetailModel->delete2($orderDetail->orderNumber()->value(), $orderDetail->productCode()->value());
    }

    public static function map(array $model): OrderDetail
    {
        return OrderDetail::create(
            OrderNumber::fromInteger($model['orderNumber']),
            ProductCode::fromString($model['productCode']),
            QuantityOrdered::fromInteger($model['quantityOrdered']),
            PriceEach::fromFloat(floatval($model['priceEach'])),
            OrderLineNumber::fromInteger($model['orderLineNumber'])
        );
    }
}
