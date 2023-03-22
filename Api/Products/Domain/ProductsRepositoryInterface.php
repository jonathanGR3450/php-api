<?php

namespace Api\Products\Domain;

use Api\Products\Domain\Aggregate\Product;
use Api\Products\Domain\ValueObjects\ProductCode;

interface ProductsRepositoryInterface
{
    public function searchByCriteria(ProductSearchCriteria $productSearchCriteria): array;

    public function create(Product $product): void;

    public function findById(ProductCode $productCode): Product;

    public function update(Product $product): void;

    public function getProducts(array $data): array;

    public function delete(Product $product): void;
}
