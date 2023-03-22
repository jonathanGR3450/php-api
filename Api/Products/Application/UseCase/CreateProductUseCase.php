<?php

declare(strict_types=1);

namespace Api\Products\Application\UseCase;

use Api\Products\Domain\Aggregate\Product;
use Api\Products\Domain\ValueObjects\ProductDescription;
use Api\Products\Domain\ValueObjects\QuantityInStock;
use Api\Products\Domain\ValueObjects\ProductScale;
use Api\Products\Domain\ValueObjects\ProductLine;
use Api\Products\Domain\ValueObjects\BuyPrice;
use Api\Products\Domain\ValueObjects\Msrp;
use Api\Products\Domain\ValueObjects\ProductName;
use Api\Products\Domain\ValueObjects\ProductCode;
use Api\Products\Domain\ValueObjects\ProductVendor;
use Api\Products\Infrastructure\ProductsRepository;

final class CreateProductUseCase
{
    private ProductsRepository $productsRepository;
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function __invoke(
        string $productCode,
        string $productName,
        string $productLine,
        string $productScale,
        string $productVendor,
        string $productDescription,
        int $quantityInStock,
        float $buyPrice,
        float $msrp
    ): array {
        $product = Product::create(
            ProductCode::fromString($productCode),
            ProductName::fromString($productName),
            ProductLine::fromString($productLine),
            ProductScale::fromString($productScale),
            ProductVendor::fromString($productVendor),
            ProductDescription::fromString($productDescription),
            QuantityInStock::fromInteger($quantityInStock),
            BuyPrice::fromFloat($buyPrice),
            Msrp::fromFloat($msrp)
        );
        $this->productsRepository->create($product);
        return $product->asArray();
    }
}
