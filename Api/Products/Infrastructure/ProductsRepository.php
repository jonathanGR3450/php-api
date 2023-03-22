<?php

declare(strict_types=1);

namespace Api\Products\Infrastructure;

use Api\Products\Domain\Aggregate\Product;
use Api\Products\Domain\ProductSearchCriteria;
use Api\Products\Domain\ProductsRepositoryInterface;
use Api\Products\Domain\ValueObjects\ProductDescription;
use Api\Products\Domain\ValueObjects\QuantityInStock;
use Api\Products\Domain\ValueObjects\ProductScale;
use Api\Products\Domain\ValueObjects\ProductLine;
use Api\Products\Domain\ValueObjects\BuyPrice;
use Api\Products\Domain\ValueObjects\Msrp;
use Api\Products\Domain\ValueObjects\ProductName;
use Api\Products\Domain\ValueObjects\ProductCode;
use Api\Products\Domain\ValueObjects\ProductVendor;
use Api\Products\Infrastructure\Models\ProductsModel;

class ProductsRepository implements ProductsRepositoryInterface
{
    private ProductsModel $productsModel;

    public function __construct(ProductsModel $productsModel)
    {
        $this->productsModel = $productsModel;
    }

    public function searchByCriteria(ProductSearchCriteria $criteria): array
    {
        $query = $this->productsModel->select();


        if (!empty($criteria->productName())) {
            $query->where('productName', 'LIKE', "'%{$criteria->productName()}%'");
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

    public function getProducts(array $data): array
    {
        $query = $this->productsModel->select()->whereIn('productCode', $data);
        return array_map(
            static fn (array $model) => self::map($model),
            $query->get()
        );
    }

    public function create(Product $product): void
    {
        $this->productsModel->create($product->asArray());
    }

    public function getNextId(): int
    {
        return $this->productsModel->getNextId();
    }

    public function findById(ProductCode $productCode): Product
    {
        $product = $this->productsModel->findById($productCode->value());
        return self::map($product);
    }

    public function update(Product $product): void
    {
        $this->productsModel->update($product->asArray(), $product->productCode()->value());
    }

    public function delete(Product $product): void
    {
        $this->productsModel->delete($product->productCode()->value());
    }

    public static function map(array $model): Product
    {
        return Product::create(
            ProductCode::fromString($model['productCode']),
            ProductName::fromString($model['productName']),
            ProductLine::fromString($model['productLine']),
            ProductScale::fromString($model['productScale']),
            ProductVendor::fromString($model['productVendor']),
            ProductDescription::fromString($model['productDescription']),
            QuantityInStock::fromInteger($model['quantityInStock']),
            BuyPrice::fromFloat((float) $model['buyPrice']),
            Msrp::fromFloat((int) $model['MSRP'])
        );
    }
}
