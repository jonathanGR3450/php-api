<?php

declare(strict_types=1);

namespace Api\Orders\Application\UseCase;

use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Infrastructure\OrdersRepository;

final class UpdateOrderUseCase
{
    private OrdersRepository $ordersRepository;
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function __invoke(
        string $id,
        string $orderDate,
        string $requiredDate,
        string $status,
        int $customerNumber,
        ?string $shippedDate = null,
        ?string $comments = null
    ): array {
        $order = $this->ordersRepository->findById(OrderNumber::fromInteger((int) $id));

        if ($orderDate) {
            $order->updateOrderDate($orderDate);
        }
        if ($requiredDate) {
            $order->updateRequiredDate($requiredDate);
        }

        if ($customerNumber) {
            $order->updateCustomerNumber($customerNumber);
        }
        if ($shippedDate) {
            $order->updateShippedDate($shippedDate);
        }
        if ($status) {
            $order->updateStatus($status);
        }
        if ($comments) {
            $order->updateComments($comments);
        }
        $this->ordersRepository->update($order);
        return $order->asArray();
    }
}
