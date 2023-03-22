<?php

namespace Api\Payments\Application\UseCase;

use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Customers\Infrastructure\CustomersRepository;
use Api\Orders\Domain\Aggregate\OrderDetail;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Infrastructure\OrderDetailRepository;
use Api\Orders\Infrastructure\OrdersRepository;
use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Payments\Infrastructure\PDF\GeneratePdf;
use Api\Payments\Infrastructure\PaymentsRepository;
use Api\Products\Infrastructure\ProductsRepository;

final class PdfPaymentUseCase
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

    public function __invoke(int $customerNumber, string $checkNumber): string
    {

        // buscar el payment
        $payment = $this->paymentsRepository->findById(CustomerNumber::fromInteger($customerNumber), CheckNumber::fromString($checkNumber));
        $order = $this->ordersRepository->findById($payment->orderNumber());
        $customer = $this->customersRepository->findById($order->customerNumber());

        $orderDetails = $this->orderDetailRepository->findByOrder($order);
        $payments = $this->paymentsRepository->findByOrderNumber($order->orderNumber());

        $pdf = GeneratePdf::create($order, $orderDetails, $customer, $payments);
        $pdf->generatePdf();

        return $pdf->getPdf();
    }
}
