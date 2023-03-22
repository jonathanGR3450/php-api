<?php

declare(strict_types=1);

namespace Api\Customers\Domain\Aggregate;

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

final class Customer
{
    private function __construct(
        private CustomerNumber $customerNumber,
        private CustomerName $customerName,
        private ContactLastName $contactLastName,
        private ContactFirstName $contactFirstName,
        private Phone $phone,
        private AddressLine1 $addressLine1,
        private City $city,
        private Country $country,
        private CreditLimit $creditLimit,
        private ?AddressLine2 $addressLine2  = null,
        private ?State $state = null,
        private ?PostalCode $postalCode = null,
        private ?SalesRepEmployeeNumber $salesRepEmployeeNumber = null
    ) {
    }

    public static function create(
        CustomerNumber $customerNumber,
        CustomerName $customerName,
        ContactLastName $contactLastName,
        ContactFirstName $contactFirstName,
        Phone $phone,
        AddressLine1 $addressLine1,
        City $city,
        Country $country,
        CreditLimit $creditLimit,
        ?AddressLine2 $addressLine2 = null,
        ?State $state = null,
        ?PostalCode $postalCode = null,
        ?SalesRepEmployeeNumber $salesRepEmployeeNumber = null
    ) {
        return new self(
            $customerNumber,
            $customerName,
            $contactLastName,
            $contactFirstName,
            $phone,
            $addressLine1,
            $city,
            $country,
            $creditLimit,
            $addressLine2,
            $state,
            $postalCode,
            $salesRepEmployeeNumber
        );
    }

    /**
     * Get the value of customerNumber
     */
    public function customerNumber(): CustomerNumber
    {
        return $this->customerNumber;
    }

    /**
     * Set the value of customerNumber
     *
     * @return  void
     */
    public function updateCustomerNumber(int $customerNumber): void
    {
        $this->customerNumber = CustomerNumber::fromInteger($customerNumber);
    }

    /**
     * Get the value of customerName
     */
    public function customerName(): CustomerName
    {
        return $this->customerName;
    }

    /**
     * Set the value of customerName
     *
     * @return  void
     */
    public function updateCustomerName(string $customerName): void
    {
        $this->customerName = CustomerName::fromString($customerName);
    }

    /**
     * Get the value of contactLastName
     */
    public function contactLastName(): ContactLastName
    {
        return $this->contactLastName;
    }

    /**
     * Set the value of contactLastName
     *
     * @return  void
     */
    public function updateContactLastName(string $contactLastName): void
    {
        $this->contactLastName = ContactLastName::fromString($contactLastName);
    }

    /**
     * Get the value of contactFirstName
     */
    public function contactFirstName(): ContactFirstName
    {
        return $this->contactFirstName;
    }

    /**
     * Set the value of contactFirstName
     *
     * @return  void
     */
    public function updateContactFirstName(string $contactFirstName): void
    {
        $this->contactFirstName = ContactFirstName::fromString($contactFirstName);
    }

    /**
     * Get the value of phone
     */
    public function phone(): Phone
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  void
     */
    public function updatePhone(string $phone): void
    {
        $this->phone = Phone::fromString($phone);
    }

    /**
     * Get the value of addressLine1
     */
    public function addressLine1(): AddressLine1
    {
        return $this->addressLine1;
    }

    /**
     * Set the value of addressLine1
     *
     * @return  void
     */
    public function updateAddressLine1(string $addressLine1): void
    {
        $this->addressLine1 = AddressLine1::fromString($addressLine1);
    }

    /**
     * Get the value of addressLine2
     */
    public function addressLine2(): ?AddressLine2
    {
        return $this->addressLine2;
    }

    /**
     * Set the value of addressLine2
     *
     * @return  void
     */
    public function updateAddressLine2(string $addressLine2): void
    {
        $this->addressLine2 = AddressLine2::fromString($addressLine2);
    }

    /**
     * Get the value of city
     */
    public function city(): City
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  void
     */
    public function updateCity(string $city): void
    {
        $this->city = City::fromString($city);
    }

    /**
     * Get the value of state
     */
    public function state(): ?State
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  void
     */
    public function updateState(string $state): void
    {
        $this->state = State::fromString($state);
    }

    /**
     * Get the value of postalCode
     */
    public function postalCode(): ?PostalCode
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     *
     * @return  void
     */
    public function updatePostalCode(string $postalCode): void
    {
        $this->postalCode = PostalCode::fromString($postalCode);
    }

    /**
     * Get the value of country
     */
    public function country(): Country
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  void
     */
    public function updateCountry(string $country): void
    {
        $this->country = Country::fromString($country);
    }

    /**
     * Get the value of salesRepEmployeeNumber
     */
    public function salesRepEmployeeNumber(): ?SalesRepEmployeeNumber
    {
        return $this->salesRepEmployeeNumber;
    }

    /**
     * Set the value of salesRepEmployeeNumber
     *
     * @return  void
     */
    public function updateSalesRepEmployeeNumber(int $salesRepEmployeeNumber): void
    {
        $this->salesRepEmployeeNumber = SalesRepEmployeeNumber::fromInteger($salesRepEmployeeNumber);
    }

    /**
     * Get the value of creditLimit
     */
    public function creditLimit(): CreditLimit
    {
        return $this->creditLimit;
    }

    /**
     * Set the value of creditLimit
     *
     * @return  void
     */
    public function updateCreditLimit(int $creditLimit): void
    {
        $this->creditLimit = CreditLimit::fromInteger($creditLimit);
    }

    public function asArray(): array
    {
        return [
            'customerNumber' => $this->customerNumber()->value(),
            'customerName' => $this->customerName()->value(),
            'contactLastName' => $this->contactLastName()->value(),
            'contactFirstName' => $this->contactFirstName()->value(),
            'phone' => $this->phone()->value(),
            'addressLine1' => $this->addressLine1()->value(),
            'addressLine2' => $this->addressLine2()?->value(),
            'city' => $this->city()->value(),
            'state' => $this->state()?->value(),
            'postalCode' => $this->postalCode()?->value(),
            'country' => $this->country()->value(),
            'salesRepEmployeeNumber' => $this->salesRepEmployeeNumber()?->value(),
            'creditLimit' => $this->creditLimit()->value()
        ];
    }
}
