<?php

declare(strict_types=1);

namespace Api\Orders\Application\UseCase;

use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Infrastructure\OrdersRepository;

final class DeleteOrderUseCase
{
    private OrdersRepository $ordersRepository;
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function __invoke(
        string $id,
    ): void {
        $order = $this->ordersRepository->findById(OrderNumber::fromInteger((int) $id));
        $this->ordersRepository->delete($order);
    }
}
