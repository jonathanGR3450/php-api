<?php

declare(strict_types=1);

namespace Api\Customers\Application\UseCase;

use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Customers\Infrastructure\CustomersRepository;

final class DeleteUseCase
{
    private CustomersRepository $customersRepository;
    public function __construct(CustomersRepository $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    public function __invoke(
        string $id,
    ): void {
        $customer = $this->customersRepository->findById(CustomerNumber::fromInteger((int) $id));
        $this->customersRepository->delete($customer);
    }
}
