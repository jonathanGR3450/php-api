<?php

declare(strict_types=1);

namespace Api\Customers\Infrastructure;

use Api\Customers\Domain\Aggregate\Customer;
use Api\Customers\Domain\CustomerSearchCriteria;
use Api\Customers\Domain\CustomersRepositoryInterface;
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
use Api\Customers\Infrastructure\Models\CustomersModel;

class CustomersRepository implements CustomersRepositoryInterface
{
    private CustomersModel $customersModel;

    public function __construct(CustomersModel $customersModel)
    {
        $this->customersModel = $customersModel;
    }

    public function searchByCriteria(CustomerSearchCriteria $criteria): array
    {
        $query = $this->customersModel->select();

        if (!empty($criteria->customerNumber())) {
            $query->where('customerNumber', 'LIKE', "'%{$criteria->customerNumber()}%'");
        }

        if (!empty($criteria->contactLastName())) {
            $query->where('contactLastName', 'LIKE', "'%{$criteria->contactLastName()}%'");
        }

        if (!empty($criteria->contactFirstName())) {
            $query->where('contactFirstName', 'LIKE', "'%{$criteria->contactFirstName()}%'");
        }

        if ($criteria->pagination() !== null) {
            $query->limit(
                $criteria->pagination()->limit()->value(),
                $criteria->pagination()->offset()->value()
            );
        }


        return array_map(
            static fn (array $model) => self::map($model),
            $query->get()
        );
    }

    public function create(Customer $customer): void
    {
        $this->customersModel->create($customer->asArray());
    }

    public function getNextId(): int
    {
        return $this->customersModel->getNextId();
    }

    public function findById(CustomerNumber $customerNumber): Customer
    {
        $customer = $this->customersModel->findById($customerNumber->value());
        return self::map($customer);
    }

    public function update(Customer $customer): void
    {
        $this->customersModel->update($customer->asArray(), $customer->customerNumber()->value());
    }

    public function delete(Customer $customer): void
    {
        $this->customersModel->delete($customer->customerNumber()->value());
    }

    public static function map(array $model): Customer
    {
        return Customer::create(
            CustomerNumber::fromInteger($model['customerNumber']),
            CustomerName::fromString($model['customerName']),
            ContactLastName::fromString($model['contactLastName']),
            ContactFirstName::fromString($model['contactFirstName']),
            Phone::fromString($model['phone']),
            AddressLine1::fromString($model['addressLine1']),
            City::fromString($model['city']),
            Country::fromString($model['country']),
            CreditLimit::fromInteger((int) $model['creditLimit']),
            !empty($model['addressLine2']) ? AddressLine2::fromString($model['addressLine2']) : null,
            !empty($model['state']) ? State::fromString($model['state']) : null,
            !empty($model['postalCode']) ? PostalCode::fromString($model['postalCode']) : null,
            !empty($model['salesRepEmployeeNumber']) ? SalesRepEmployeeNumber::fromInteger((int) $model['salesRepEmployeeNumber']) : null
        );
    }
}
