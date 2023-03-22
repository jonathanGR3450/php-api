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

final class UpdateUseCase
{
    private CustomersRepository $customersRepository;
    public function __construct(CustomersRepository $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    public function __invoke(
        string $id,
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
        $customer = $this->customersRepository->findById(CustomerNumber::fromInteger((int)$id));

        if ($customerName) {
            $customer->updateCustomerName($customerName);
        }
        if ($contactLastName) {
            $customer->updateContactLastName($contactLastName);
        }

        if ($contactFirstName) {
            $customer->updateContactFirstName($contactFirstName);
        }
        if ($phone) {
            $customer->updatePhone($phone);
        }
        if ($addressLine1) {
            $customer->updateAddressLine1($addressLine1);
        }
        if ($city) {
            $customer->updateCity($city);
        }
        if ($country) {
            $customer->updateCountry($country);
        }
        if ($creditLimit) {
            $customer->updateCreditLimit($creditLimit);
        }
        if ($addressLine2) {
            $customer->updateAddressLine2($addressLine2);
        }
        if ($state) {
            $customer->updateState($state);
        }
        if ($postalCode) {
            $customer->updatePostalCode($postalCode);
        }
        if ($salesRepEmployeeNumber) {
            $customer->updateSalesRepEmployeeNumber($salesRepEmployeeNumber);
        }
        $this->customersRepository->update($customer);
        return $customer->asArray();
    }
}
