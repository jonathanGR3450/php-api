<?php

namespace Api\Products\Application\UseCase;

use Api\Products\Domain\Aggregate\Product;
use Api\Products\Domain\ProductSearchCriteria;
use Api\Products\Infrastructure\ProductsRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexProductsUseCase
{
    private ProductsRepository $productsRepository;
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function __invoke(?int $offset = null, ?string $productName = null): array
    {
        $criteria = ProductSearchCriteria::create($offset, $productName);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('productCode'), CriteriaSortDirection::ASC));
        $data = $this->productsRepository->searchByCriteria($criteria);

        return array_map(fn (Product $product) => $product->asArray(), $data);
    }
}