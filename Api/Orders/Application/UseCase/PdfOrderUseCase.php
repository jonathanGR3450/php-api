<?php

namespace Api\Orders\Application\UseCase;

use Api\Customers\Infrastructure\CustomersRepository;
use Api\Orders\Domain\Aggregate\OrderDetail;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Infrastructure\OrderDetailRepository;
use Api\Orders\Infrastructure\OrdersRepository;
use Api\Orders\Infrastructure\PDF\GeneratePdf;
use Api\Payments\Infrastructure\PaymentsRepository;
use Api\Products\Infrastructure\ProductsRepository;

final class PdfOrderUseCase
{
    private OrdersRepository $ordersRepository;
    private OrderDetailRepository $orderDetailRepository;
    private CustomersRepository $customersRepository;
    private ProductsRepository $productsRepository;
    private PaymentsRepository $paymentsRepository;

    public function __construct(
        OrdersRepository $ordersRepository,
        OrderDetailRepository $orderDetailRepository,
        CustomersRepository $customersRepository,
        ProductsRepository $productsRepository,
        PaymentsRepository $paymentsRepository
    ) {
        $this->ordersRepository = $ordersRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->customersRepository = $customersRepository;
        $this->productsRepository = $productsRepository;
        $this->paymentsRepository = $paymentsRepository;
    }

    public function __invoke(int $orderNumber): string
    {
        $order = $this->ordersRepository->findById(OrderNumber::fromInteger($orderNumber));
        $orderDetails = $this->orderDetailRepository->findByOrder($order);
        $customer = $this->customersRepository->findById($order->customerNumber());

        $payments = $this->paymentsRepository->findByOrderNumber($order->orderNumber());

        $orderDetailsArray = array_map(fn (OrderDetail $orderDetail) => $orderDetail->asArray(), $orderDetails);

        $productsKey = array_column($orderDetailsArray, 'productCode');
        $products = $this->productsRepository->getProducts($productsKey);

        $pdf = GeneratePdf::create($order, $orderDetails, $customer, $products, $payments);
        $pdf->generatePdf();

        return $pdf->getPdf();
    }
}
