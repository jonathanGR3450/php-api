<?php

declare(strict_types=1);

namespace Api\Orders\Application\UseCase\OrderDetail;

use Api\Orders\Domain\Aggregate\OrderDetail;
use Api\Orders\Domain\ValueObjects\OrderDetail\OrderLineNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\OrderDetail\PriceEach;
use Api\Orders\Domain\ValueObjects\OrderDetail\ProductCode;
use Api\Orders\Domain\ValueObjects\OrderDetail\QuantityOrdered;
use Api\Orders\Infrastructure\OrderDetailRepository;

final class CreateOrderDetailUseCase
{
    private OrderDetailRepository $orderDetailRepository;
    public function __construct(OrderDetailRepository $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function __invoke(
        int $orderNumber,
        string $productCode,
        int $quantityOrdered,
        float $priceEach,
        int $orderLineNumber
    ): array {
        $orderDetail = OrderDetail::create(
            OrderNumber::fromInteger($orderNumber),
            ProductCode::fromString($productCode),
            QuantityOrdered::fromInteger($quantityOrdered),
            PriceEach::fromFloat($priceEach),
            OrderLineNumber::fromInteger($orderLineNumber)
        );
        $this->orderDetailRepository->create($orderDetail);
        return $orderDetail->asArray();
    }
}
