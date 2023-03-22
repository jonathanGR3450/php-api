<?php

declare(strict_types=1);

namespace Api\Payments\Application\UseCase;

use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Payments\Infrastructure\PaymentsRepository;

final class UpdatePaymentsUseCase
{
    private PaymentsRepository $paymentsRepository;
    public function __construct(PaymentsRepository $paymentsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
    }

    public function __invoke(
        string $id,
        string $id2,
        string $paymentDate,
        float $amount,
        int $orderNumber
    ): array {
        $payment = $this->paymentsRepository->findById(CustomerNumber::fromInteger((int) $id), CheckNumber::fromString($id2));

        if ($paymentDate) {
            $payment->updatePaymentDate($paymentDate);
        }
        if ($amount) {
            $payment->updateAmount($amount);
        }
        if ($orderNumber) {
            $payment->updateOrderNumber($orderNumber);
        }
        $this->paymentsRepository->update($payment);
        return $payment->asArray();
    }
}
