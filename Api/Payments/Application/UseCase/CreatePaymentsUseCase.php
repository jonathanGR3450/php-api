<?php

declare(strict_types=1);

namespace Api\Payments\Application\UseCase;

use Api\Payments\Domain\Aggregate\Payments;
use Api\Payments\Domain\ValueObjects\Amount;
use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Payments\Domain\ValueObjects\PaymentDate;
use Api\Payments\Infrastructure\PaymentsRepository;

final class CreatePaymentsUseCase
{
    private PaymentsRepository $paymentsRepository;
    public function __construct(PaymentsRepository $paymentsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
    }

    public function __invoke(
        int $customerNumber,
        string $paymentDate,
        float $amount,
        ?int $orderNumber = null
    ): array {
        $payments = Payments::create(
            CustomerNumber::fromInteger($customerNumber),
            CheckNumber::random(),
            PaymentDate::fromPrimitives($paymentDate),
            Amount::fromFloat($amount),
            !empty($orderNumber) ? OrderNumber::fromInteger($orderNumber) : null
        );
        $this->paymentsRepository->create($payments);
        return $payments->asArray();
    }
}
