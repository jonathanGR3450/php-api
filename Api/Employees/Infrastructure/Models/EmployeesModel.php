<?php

namespace Api\Employees\Infrastructure\Models;

use Api\Shared\Infrastructure\Models\Database;

class EmployeesModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'employees';
        $this->pk = 'employeeNumber';
    }

    public function getEmployees()
    {
        return $this->query("SELECT * FROM $this->table ORDER BY employeeNumber ASC LIMIT ?", ["i", 10]);
    }

}
