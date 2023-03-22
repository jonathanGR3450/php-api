<?php

namespace Api\Employees\Domain;

use Api\Employees\Domain\Aggregate\Employees;
use Api\Employees\Domain\ValueObjects\EmployeesNumber;

interface EmployeesRepositoryInterface
{
    public function searchByCriteria(EmployeesSearchCriteria $employeesSearchCriteria): array;

    public function create(Employees $employees): void;

    public function findById(EmployeesNumber $employeeNumber): Employees;

    public function update(Employees $employees): void;

    public function delete(Employees $employees): void;
}
