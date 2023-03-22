<?php

declare(strict_types=1);

namespace Api\Payments\Application\UseCase;

use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Payments\Domain\ValueObjects\OrderNumber;
use Api\Payments\Domain\ValueObjects\ProductCode;
use Api\Payments\Infrastructure\PaymentsRepository;

final class DeletePaymentsUseCase
{
    private PaymentsRepository $paymentsRepository;
    public function __construct(PaymentsRepository $paymentsRepository)
    {
        $this->paymentsRepository = $paymentsRepository;
    }

    public function __invoke(
        string $id,
        string $id2
    ): void {
        $payment = $this->paymentsRepository->findById(CustomerNumber::fromInteger((int) $id), CheckNumber::fromString($id2));
        $this->paymentsRepository->delete($payment);
    }
}
