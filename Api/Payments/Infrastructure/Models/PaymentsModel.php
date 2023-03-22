<?php

declare(strict_types=1);

namespace Api\Payments\Infrastructure\Models;

use Api\Shared\Domain\Exception\NotFoundException;
use Api\Shared\Infrastructure\Models\Database;

class PaymentsModel extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'payments';
        $this->pk = 'customerNumber';
        $this->pk2 = 'checkNumber';
    }

    public function getPayments(int $customerNumber, string $checkNumber): array
    {
        $data = $this->query("SELECT * FROM $this->table WHERE customerNumber = $customerNumber AND checkNumber='$checkNumber'");
        if (count($data) == 0) {
            throw new NotFoundException("Payment Not Found");
        }
        return $data[0];
    }

}
