<?php

declare(strict_types=1);

namespace Api\Orders\Application\UseCase;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\Comments;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\OrderDate;
use Api\Orders\Domain\ValueObjects\RequiredDate;
use Api\Orders\Domain\ValueObjects\ShippedDate;
use Api\Orders\Domain\ValueObjects\Status;
use Api\Orders\Infrastructure\OrdersRepository;

final class CreateOrderUseCase
{
    private OrdersRepository $ordersRepository;
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function __invoke(
        string $orderDate,
        string $requiredDate,
        string $status,
        int $customerNumber,
        ?string $shippedDate = null,
        ?string $comments = null
    ): array {
        $orderNumber = $this->ordersRepository->getNextId();
        $order = Order::create(
            OrderNumber::fromInteger($orderNumber),
            OrderDate::fromPrimitives($orderDate),
            RequiredDate::fromPrimitives($requiredDate),
            Status::fromString($status),
            CustomerNumber::fromInteger($customerNumber),
            !empty($shippedDate) ? ShippedDate::fromPrimitives($shippedDate) : null,
            !empty($comments) ? Comments::fromString($comments) : null
        );
        $this->ordersRepository->create($order);
        return $order->asArray();
    }
}
