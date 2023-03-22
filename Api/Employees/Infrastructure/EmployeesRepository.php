<?php

declare(strict_types=1);

namespace Api\Employees\Infrastructure;

use Api\Employees\Domain\Aggregate\Employees;
use Api\Employees\Domain\EmployeesSearchCriteria;
use Api\Employees\Domain\EmployeesRepositoryInterface;
use Api\Employees\Domain\ValueObjects\Email;
use Api\Employees\Domain\ValueObjects\LastName;
use Api\Employees\Domain\ValueObjects\EmployeesNumber;
use Api\Employees\Domain\ValueObjects\Extension;
use Api\Employees\Domain\ValueObjects\FirstName;
use Api\Employees\Domain\ValueObjects\JobTitle;
use Api\Employees\Domain\ValueObjects\OfficeCode;
use Api\Employees\Domain\ValueObjects\ReportsTo;
use Api\Employees\Infrastructure\Models\EmployeesModel;

class EmployeesRepository implements EmployeesRepositoryInterface
{
    private EmployeesModel $employeesModel;

    public function __construct(EmployeesModel $employeesModel)
    {
        $this->employeesModel = $employeesModel;
    }

    public function searchByCriteria(EmployeesSearchCriteria $criteria): array
    {
        $query = $this->employeesModel->select();

        if (!empty($criteria->lastName())) {
            $query->where('lastName', 'LIKE', "'%{$criteria->lastName()}%'");
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

    public function create(Employees $employees): void
    {
        $this->employeesModel->create($employees->asArray());
    }

    public function getNextId(): int
    {
        return $this->employeesModel->getNextId();
    }

    public function findById(EmployeesNumber $employeeNumber): Employees
    {
        $employees = $this->employeesModel->findById($employeeNumber->value());
        return self::map($employees);
    }

    public function update(Employees $employees): void
    {
        $this->employeesModel->update($employees->asArray(), $employees->employeeNumber()->value());
    }

    public function delete(Employees $employees): void
    {
        $this->employeesModel->delete($employees->employeeNumber()->value());
    }

    public static function map(array $model): Employees
    {
        return Employees::create(
            EmployeesNumber::fromInteger($model['employeeNumber']),
            LastName::fromString($model['lastName']),
            FirstName::fromString($model['firstName']),
            Extension::fromString($model['extension']),
            Email::fromString($model['email']),
            OfficeCode::fromString($model['officeCode']),
            JobTitle::fromString($model['jobTitle']),
            !empty($model['reportsTo']) ? ReportsTo::fromInteger($model['reportsTo']) : null
        );
    }
}
