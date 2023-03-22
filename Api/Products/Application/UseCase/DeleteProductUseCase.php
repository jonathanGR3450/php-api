<?php

declare(strict_types=1);

namespace Api\Products\Application\UseCase;

use Api\Products\Domain\ValueObjects\ProductCode;
use Api\Products\Infrastructure\ProductsRepository;

final class DeleteProductUseCase
{
    private ProductsRepository $productsRepository;
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function __invoke(
        string $id,
    ): void {
        $product = $this->productsRepository->findById(ProductCode::fromString($id));
        $this->productsRepository->delete($product);
    }
}
