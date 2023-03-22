<?php

namespace Api\Orders\Application\UseCase\OrderDetail;

use Api\Orders\Domain\Aggregate\Order;
use Api\Orders\Domain\Aggregate\OrderDetail;
use Api\Orders\Domain\OrderDetailSearchCriteria;
use Api\Orders\Infrastructure\OrderDetailRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexOrderDetailUseCase
{
    private OrderDetailRepository $orderDetailRepository;
    public function __construct(OrderDetailRepository $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function __invoke(?int $offset = null, ?int $orderNumber = null, ?string $productCode = null): array
    {
        $criteria = OrderDetailSearchCriteria::create($offset, $orderNumber, $productCode);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('orderNumber'), CriteriaSortDirection::DESC));
        $data = $this->orderDetailRepository->searchByCriteria($criteria);

        return array_map(fn (OrderDetail $orderDetail) => $orderDetail->asArray(), $data);
    }
}