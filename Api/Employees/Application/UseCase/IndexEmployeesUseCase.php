<?php

namespace Api\Employees\Application\UseCase;

use Api\Employees\Domain\Aggregate\Employees;
use Api\Employees\Domain\EmployeesSearchCriteria;
use Api\Employees\Infrastructure\EmployeesRepository;
use Api\Shared\Domain\Models\CriteriaField;
use Api\Shared\Domain\Models\CriteriaSort;
use Api\Shared\Domain\Models\CriteriaSortDirection;

final class IndexEmployeesUseCase
{
    private EmployeesRepository $employeesRepository;
    public function __construct(EmployeesRepository $employeesRepository)
    {
        $this->employeesRepository = $employeesRepository;
    }

    public function __invoke(?int $offset = null, ?string $lastName = null): array
    {
        $criteria = EmployeesSearchCriteria::create($offset, $lastName);
        $criteria->sortBy(new CriteriaSort(CriteriaField::fromString('employeeNumber'), CriteriaSortDirection::ASC));
        $data = $this->employeesRepository->searchByCriteria($criteria);

        return array_map(fn (Employees $employees) => $employees->asArray(), $data);
    }
}