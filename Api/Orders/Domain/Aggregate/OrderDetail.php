<?php

declare(strict_types=1);

namespace Api\Orders\Domain\Aggregate;

use Api\Orders\Domain\ValueObjects\OrderDetail\OrderLineNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\OrderDetail\PriceEach;
use Api\Orders\Domain\ValueObjects\OrderDetail\ProductCode;
use Api\Orders\Domain\ValueObjects\OrderDetail\QuantityOrdered;

final class OrderDetail
{
    private function __construct(
        private OrderNumber $orderNumber,
        private ProductCode $productCode,
        private QuantityOrdered $quantityOrdered,
        private PriceEach $priceEach,
        private OrderLineNumber $orderLineNumber
    ) {
    }

    public static function create(
        OrderNumber $orderNumber,
        ProductCode $productCode,
        QuantityOrdered $quantityOrdered,
        PriceEach $priceEach,
        OrderLineNumber $orderLineNumber
    ) {
        return new self(
            $orderNumber,
            $productCode,
            $quantityOrdered,
            $priceEach,
            $orderLineNumber
        );
    }

    /**
     * Get the value of orderNumber
     */
    public function orderNumber(): OrderNumber
    {
        return $this->orderNumber;
    }

    /**
     * Set the value of orderNumber
     *
     * @return  void
     */
    public function updateOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = OrderNumber::fromInteger($orderNumber);
    }

    /**
     * Get the value of productCode
     */
    public function productCode(): ProductCode
    {
        return $this->productCode;
    }

    /**
     * Set the value of productCode
     *
     * @return  void
     */
    public function updateProductCode(string $productCode): void
    {
        $this->productCode = ProductCode::fromString($productCode);
    }

    /**
     * Get the value of quantityOrdered
     */
    public function quantityOrdered(): QuantityOrdered
    {
        return $this->quantityOrdered;
    }

    /**
     * Set the value of quantityOrdered
     *
     * @return  void
     */
    public function updateQuantityOrdered(int $quantityOrdered): void
    {
        $this->quantityOrdered = QuantityOrdered::fromInteger($quantityOrdered);
    }

    /**
     * Get the value of priceEach
     */
    public function priceEach(): PriceEach
    {
        return $this->priceEach;
    }

    /**
     * Set the value of priceEach
     *
     * @return  void
     */
    public function updatePriceEach(float $priceEach): void
    {
        $this->priceEach = PriceEach::fromFloat($priceEach);
    }

    /**
     * Get the value of orderLineNumber
     */
    public function orderLineNumber(): OrderLineNumber
    {
        return $this->orderLineNumber;
    }

    /**
     * Set the value of orderLineNumber
     *
     * @return  void
     */
    public function updateOrderLineNumber(int $orderLineNumber): void
    {
        $this->orderLineNumber = OrderLineNumber::fromInteger($orderLineNumber);
    }


    public function asArray(): array
    {
        return [
            'orderNumber' => $this->orderNumber()->value(),
            'productCode' => $this->productCode()->value(),
            'quantityOrdered' => $this->quantityOrdered()->value(),
            'priceEach' => $this->priceEach()->value(),
            'orderLineNumber' => $this->orderLineNumber()->value()
        ];
    }
}
