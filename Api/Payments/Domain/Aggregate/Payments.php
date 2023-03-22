<?php

declare(strict_types=1);

namespace Api\Payments\Domain\Aggregate;

use Api\Payments\Domain\ValueObjects\Amount;
use Api\Payments\Domain\ValueObjects\CheckNumber;
use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Payments\Domain\ValueObjects\PaymentDate;

final class Payments
{
    private function __construct(
        private CustomerNumber $customerNumber,
        private CheckNumber $checkNumber,
        private PaymentDate $paymentDate,
        private Amount $amount,
        private ?OrderNumber $orderNumber = null
    ) {
    }

    public static function create(
        CustomerNumber $customerNumber,
        CheckNumber $checkNumber,
        PaymentDate $paymentDate,
        Amount $amount,
        ?OrderNumber $orderNumber
    ) {
        return new self(
            $customerNumber,
            $checkNumber,
            $paymentDate,
            $amount,
            $orderNumber
        );
    }

    public static function uuid(): string
    {
        return strtoupper(substr(uniqid(), 7, 8));
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
     * Get the value of checkNumber
     */
    public function checkNumber(): CheckNumber
    {
        return $this->checkNumber;
    }

    /**
     * Set the value of checkNumber
     *
     * @return  void
     */
    public function updateCheckNumber(string $checkNumber): void
    {
        $this->checkNumber = CheckNumber::fromString($checkNumber);
    }

    /**
     * Get the value of paymentDate
     */
    public function paymentDate(): PaymentDate
    {
        return $this->paymentDate;
    }

    /**
     * Set the value of paymentDate
     *
     * @return  void
     */
    public function updatePaymentDate(string $paymentDate): void
    {
        $this->paymentDate = PaymentDate::fromPrimitives($paymentDate);
    }

    /**
     * Get the value of amount
     */
    public function amount(): Amount
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  void
     */
    public function updateAmount(float $amount): void
    {
        $this->amount = Amount::fromFloat($amount);
    }

    /**
     * Get the value of orderNumber
     */
    public function orderNumber(): ?OrderNumber
    {
        return $this->orderNumber;
    }

    /**
     * Set the value of orderNumber
     *
     * @return  void
     */
    public function updateOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = OrderNumber::fromInteger($orderNumber);
    }

    public function asArray(): array
    {
        return [
            'customerNumber' => $this->customerNumber()->value(),
            'checkNumber' => $this->checkNumber()->value(),
            'paymentDate' => $this->paymentDate()->value(),
            'amount' => $this->amount()->value(),
            'orderNumber' => $this->orderNumber()?->value(),
        ];
    }
}
