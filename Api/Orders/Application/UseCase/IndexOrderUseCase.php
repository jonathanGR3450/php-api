<?php

namespace Api\Orders\Application\UseCase;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\OrderSearchCriteria;
use Api\Orders\Infrastructure\OrdersRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexOrderUseCase
{
    private OrdersRepository $ordersRepository;
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function __invoke(?int $offset = null, ?int $orderNumber = null, ?int $customerNumber = null, ?string $status = null): array
    {
        $criteria = OrderSearchCriteria::create($offset, $orderNumber, $customerNumber, $status);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('orderNumber'), CriteriaSortDirection::DESC));
        $data = $this->ordersRepository->searchByCriteria($criteria);

        return array_map(fn (Order $order) => $order->asArray(), $data);
    }
}