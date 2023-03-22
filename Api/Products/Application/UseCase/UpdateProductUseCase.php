<?php

declare(strict_types=1);

namespace Api\Products\Application\UseCase;

use Api\Products\Domain\ValueObjects\ProductCode;
use Api\Products\Infrastructure\ProductsRepository;

final class UpdateProductUseCase
{
    private ProductsRepository $productsRepository;
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function __invoke(
        string $id,
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
        $product = $this->productsRepository->findById(ProductCode::fromString($id));

        if ($productCode) {
            $product->updateProductCode($productCode);
        }
        if ($productName) {
            $product->updateProductName($productName);
        }
        if ($productLine) {
            $product->updateProductLine($productLine);
        }

        if ($productScale) {
            $product->updateProductScale($productScale);
        }
        if ($productVendor) {
            $product->updateProductVendor($productVendor);
        }
        if ($productDescription) {
            $product->updateProductDescription($productDescription);
        }
        if ($quantityInStock) {
            $product->updateQuantityInStock($quantityInStock);
        }
        if ($buyPrice) {
            $product->updateBuyPrice($buyPrice);
        }
        if ($msrp) {
            $product->updateMsrp($msrp);
        }
        $this->productsRepository->update($product);
        return $product->asArray();
    }
}
