<?php

declare(strict_types=1);

namespace Api\Employees\Domain\Aggregate;

use Api\Employees\Domain\ValueObjects\LastName;
use Api\Employees\Domain\ValueObjects\Email;
use Api\Employees\Domain\ValueObjects\EmployeesNumber;
use Api\Employees\Domain\ValueObjects\Extension;
use Api\Employees\Domain\ValueObjects\FirstName;
use Api\Employees\Domain\ValueObjects\JobTitle;
use Api\Employees\Domain\ValueObjects\OfficeCode;
use Api\Employees\Domain\ValueObjects\ReportsTo;

final class Employees
{
    private function __construct(
        private EmployeesNumber $employeeNumber,
        private LastName $lastName,
        private FirstName $firstName,
        private Extension $extension,
        private Email $email,
        private OfficeCode $officeCode,
        private JobTitle $jobTitle,
        private ?ReportsTo $reportsTo = null,
    ) {
    }

    public static function create(
        EmployeesNumber $employeeNumber,
        LastName $lastName,
        FirstName $firstName,
        Extension $extension,
        Email $email,
        OfficeCode $officeCode,
        JobTitle $jobTitle,
        ?ReportsTo $reportsTo = null,
    ) {
        return new self(
            $employeeNumber,
            $lastName,
            $firstName,
            $extension,
            $email,
            $officeCode,
            $jobTitle,
            $reportsTo = null,
        );
    }

    /**
     * Get the value of employeeNumber
     */
    public function employeeNumber(): EmployeesNumber
    {
        return $this->employeeNumber;
    }

    /**
     * Set the value of employeeNumber
     *
     * @return  void
     */
    public function updateEmployeesNumber(int $employeeNumber): void
    {
        $this->employeeNumber = EmployeesNumber::fromInteger($employeeNumber);
    }

    /**
     * Get the value of lastName
     */
    public function lastName(): LastName
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  void
     */
    public function updateLastName(string $lastName): void
    {
        $this->lastName = LastName::fromString($lastName);
    }

    /**
     * Get the value of firstName
     */
    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  void
     */
    public function updateFirstName(string $firstName): void
    {
        $this->firstName = FirstName::fromString($firstName);
    }

    /**
     * Get the value of extension
     */
    public function extension(): Extension
    {
        return $this->extension;
    }

    /**
     * Set the value of extension
     *
     * @return  void
     */
    public function updateExtension(string $extension): void
    {
        $this->extension = Extension::fromString($extension);
    }

    /**
     * Get the value of email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  void
     */
    public function updateEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    /**
     * Get the value of officeCode
     */
    public function officeCode(): OfficeCode
    {
        return $this->officeCode;
    }

    /**
     * Set the value of officeCode
     *
     * @return  void
     */
    public function updateOfficeCode(string $officeCode): void
    {
        $this->officeCode = OfficeCode::fromString($officeCode);
    }

    /**
     * Get the value of jobTitle
     */
    public function jobTitle(): JobTitle
    {
        return $this->jobTitle;
    }

    /**
     * Set the value of jobTitle
     *
     * @return  void
     */
    public function updateJobTitle(string $jobTitle): void
    {
        $this->jobTitle = JobTitle::fromString($jobTitle);
    }

    /**
     * Get the value of reportsTo
     */
    public function reportsTo(): ?ReportsTo
    {
        return $this->reportsTo;
    }

    /**
     * Set the value of reportsTo
     *
     * @return  void
     */
    public function updateReportsTo(int $reportsTo): void
    {
        $this->reportsTo = ReportsTo::fromInteger($reportsTo);
    }
    public function asArray(): array
    {
        return [
            'employeeNumber' => $this->employeeNumber()->value(),
            'lastName' => $this->lastName()->value(),
            'firstName' => $this->firstName()->value(),
            'extension' => $this->extension()->value(),
            'email' => $this->email()->value(),
            'officeCode' => $this->officeCode()->value(),
            'jobTitle' => $this->jobTitle()->value(),
            'reportsTo' => $this->reportsTo()?->value()
        ];
    }
}
