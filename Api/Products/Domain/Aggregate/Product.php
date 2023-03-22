<?php

declare(strict_types=1);

namespace Api\Products\Domain\Aggregate;

use Api\Products\Domain\ValueObjects\ProductDescription;
use Api\Products\Domain\ValueObjects\QuantityInStock;
use Api\Products\Domain\ValueObjects\ProductScale;
use Api\Products\Domain\ValueObjects\ProductLine;
use Api\Products\Domain\ValueObjects\BuyPrice;
use Api\Products\Domain\ValueObjects\Msrp;
use Api\Products\Domain\ValueObjects\ProductName;
use Api\Products\Domain\ValueObjects\ProductCode;
use Api\Products\Domain\ValueObjects\ProductVendor;

final class Product
{
    private function __construct(
        private ProductCode $productCode,
        private ProductName $productName,
        private ProductLine $productLine,
        private ProductScale $productScale,
        private ProductVendor $productVendor,
        private ProductDescription $productDescription,
        private QuantityInStock $quantityInStock,
        private BuyPrice $buyPrice,
        private Msrp $msrp
    ) {
    }

    public static function create(
        ProductCode $productCode,
        ProductName $productName,
        ProductLine $productLine,
        ProductScale $productScale,
        ProductVendor $productVendor,
        ProductDescription $productDescription,
        QuantityInStock $quantityInStock,
        BuyPrice $buyPrice,
        Msrp $msrp
    ) {
        return new self(
            $productCode,
            $productName,
            $productLine,
            $productScale,
            $productVendor,
            $productDescription,
            $quantityInStock,
            $buyPrice,
            $msrp
        );
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
     * Get the value of productName
     */
    public function productName(): ProductName
    {
        return $this->productName;
    }

    /**
     * Set the value of productName
     *
     * @return  void
     */
    public function updateProductName(string $productName): void
    {
        $this->productName = ProductName::fromString($productName);
    }

    /**
     * Get the value of productLine
     */
    public function productLine(): ProductLine
    {
        return $this->productLine;
    }

    /**
     * Set the value of productLine
     *
     * @return  void
     */
    public function updateProductLine(string $productLine): void
    {
        $this->productLine = ProductLine::fromString($productLine);
    }

    /**
     * Get the value of productScale
     */
    public function productScale(): ProductScale
    {
        return $this->productScale;
    }

    /**
     * Set the value of productScale
     *
     * @return  void
     */
    public function updateProductScale(string $productScale): void
    {
        $this->productScale = ProductScale::fromString($productScale);
    }

    /**
     * Get the value of productVendor
     */
    public function productVendor(): ProductVendor
    {
        return $this->productVendor;
    }

    /**
     * Set the value of productVendor
     *
     * @return  void
     */
    public function updateProductVendor(string $productVendor): void
    {
        $this->productVendor = ProductVendor::fromString($productVendor);
    }

    /**
     * Get the value of productDescription
     */
    public function productDescription(): ProductDescription
    {
        return $this->productDescription;
    }

    /**
     * Set the value of productDescription
     *
     * @return  void
     */
    public function updateProductDescription(string $productDescription): void
    {
        $this->productDescription = ProductDescription::fromString($productDescription);
    }


    /**
     * Get the value of quantityInStock
     */
    public function quantityInStock(): QuantityInStock
    {
        return $this->quantityInStock;
    }

    /**
     * Set the value of quantityInStock
     *
     * @return  void
     */
    public function updateQuantityInStock(int $quantityInStock): void
    {
        $this->quantityInStock = QuantityInStock::fromInteger($quantityInStock);
    }



    /**
     * Get the value of buyPrice
     */
    public function buyPrice(): BuyPrice
    {
        return $this->buyPrice;
    }

    /**
     * Set the value of buyPrice
     *
     * @return  void
     */
    public function updateBuyPrice(float $buyPrice): void
    {
        $this->buyPrice = BuyPrice::fromFloat($buyPrice);
    }


    /**
     * Get the value of msrp
     */
    public function msrp(): Msrp
    {
        return $this->msrp;
    }

    /**
     * Set the value of msrp
     *
     * @return  void
     */
    public function updateMsrp(float $msrp): void
    {
        $this->msrp = Msrp::fromFloat($msrp);
    }

    public function asArray(): array
    {
        return [
            'productCode' => $this->productCode()->value(),
            'productName' => $this->productName()->value(),
            'productLine' => $this->productLine()->value(),
            'productScale' => $this->productScale()->value(),
            'productVendor' => $this->productVendor()->value(),
            'productDescription' => $this->productDescription()->value(),
            'quantityInStock' => $this->quantityInStock()->value(),
            'buyPrice' => $this->buyPrice()->value(),
            'msrp' => $this->msrp()->value()
        ];
    }
}
