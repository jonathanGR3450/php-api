<?php

declare(strict_types=1);

namespace Api\Customers\Application\UseCase;

use Api\Customers\Domain\Aggregate\Customer;
use Api\Customers\Domain\ValueObjects\AddressLine1;
use Api\Customers\Domain\ValueObjects\AddressLine2;
use Api\Customers\Domain\ValueObjects\City;
use Api\Customers\Domain\ValueObjects\ContactFirstName;
use Api\Customers\Domain\ValueObjects\ContactLastName;
use Api\Customers\Domain\ValueObjects\Country;
use Api\Customers\Domain\ValueObjects\CreditLimit;
use Api\Customers\Domain\ValueObjects\CustomerName;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Customers\Domain\ValueObjects\Phone;
use Api\Customers\Domain\ValueObjects\PostalCode;
use Api\Customers\Domain\ValueObjects\SalesRepEmployeeNumber;
use Api\Customers\Domain\ValueObjects\State;
use Api\Customers\Infrastructure\CustomersRepository;

final class CreateUseCase
{
    private CustomersRepository $customersRepository;
    public function __construct(CustomersRepository $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    public function __invoke(
        string $customerName,
        string $contactLastName,
        string $contactFirstName,
        string $phone,
        string $addressLine1,
        string $city,
        string $country,
        int $creditLimit,
        ?string $addressLine2 = null,
        ?string $state = null,
        ?string $postalCode = null,
        ?int $salesRepEmployeeNumber = null
    ): array {
        $customerNumber = $this->customersRepository->getNextId();
        $customer = Customer::create(
            CustomerNumber::fromInteger($customerNumber),
            CustomerName::fromString($customerName),
            ContactLastName::fromString($contactLastName),
            ContactFirstName::fromString($contactFirstName),
            Phone::fromString($phone),
            AddressLine1::fromString($addressLine1),
            City::fromString($city),
            Country::fromString($country),
            CreditLimit::fromInteger($creditLimit),
            !empty($addressLine2) ? AddressLine2::fromString($addressLine2) : null,
            !empty($state) ? State::fromString($state) : null,
            !empty($postalCode) ? PostalCode::fromString($postalCode) : null,
            !empty($salesRepEmployeeNumber) ? SalesRepEmployeeNumber::fromInteger((int) $salesRepEmployeeNumber) : null
        );
        $this->customersRepository->create($customer);
        return $customer->asArray();
    }
}
