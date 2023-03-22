<?php

declare(strict_types=1);

namespace Api\Orders\Application\UseCase\OrderDetail;

use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\OrderDetail\ProductCode;
use Api\Orders\Infrastructure\OrderDetailRepository;

final class DeleteOrderDetailUseCase
{
    private OrderDetailRepository $orderDetailRepository;
    public function __construct(OrderDetailRepository $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function __invoke(
        string $id,
        string $id2
    ): void {
        $order = $this->orderDetailRepository->findByOrderProduct(OrderNumber::fromInteger((int) $id), ProductCode::fromString($id2));
        $this->orderDetailRepository->delete($order);
    }
}
