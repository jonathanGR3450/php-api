<?php

declare(strict_types=1);

namespace Api\Orders\Application\UseCase\OrderDetail;

use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\OrderDetail\ProductCode;
use Api\Orders\Infrastructure\OrderDetailRepository;

final class UpdateOrderDetailUseCase
{
    private OrderDetailRepository $orderDetailRepository;
    public function __construct(OrderDetailRepository $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function __invoke(
        string $id,
        string $id2,
        int $orderNumber,
        string $productCode,
        int $quantityOrdered,
        float $priceEach,
        int $orderLineNumber
    ): array {
        $orderDetail = $this->orderDetailRepository->findByOrderProduct(OrderNumber::fromInteger((int) $id), ProductCode::fromString($id2));

        if ($productCode) {
            $orderDetail->updateProductCode($productCode);
        }
        // if ($orderNumber) {
        //     $order->updateOrderNumber($orderNumber);
        // }

        if ($priceEach) {
            $orderDetail->updatePriceEach($priceEach);
        }
        if ($orderLineNumber) {
            $orderDetail->updateOrderLineNumber($orderLineNumber);
        }
        if ($quantityOrdered) {
            $orderDetail->updateQuantityOrdered($quantityOrdered);
        }
        $this->orderDetailRepository->update($orderDetail);
        return $orderDetail->asArray();
    }
}
