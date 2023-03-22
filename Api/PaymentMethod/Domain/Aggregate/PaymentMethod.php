<?php

declare(strict_types=1);

namespace Api\PaymentMethod\Domain\Aggregate;

use Api\PaymentMethod\Domain\ValueObjects\AddressLine1;
use Api\PaymentMethod\Domain\ValueObjects\AddressLine2;
use Api\PaymentMethod\Domain\ValueObjects\City;
use Api\PaymentMethod\Domain\ValueObjects\ContactFirstName;
use Api\PaymentMethod\Domain\ValueObjects\DescriptioMethod;
use Api\PaymentMethod\Domain\ValueObjects\Country;
use Api\PaymentMethod\Domain\ValueObjects\CreditLimit;
use Api\PaymentMethod\Domain\ValueObjects\NameMethod;
use Api\PaymentMethod\Domain\ValueObjects\PaymentMethodNumber;
use Api\PaymentMethod\Domain\ValueObjects\Phone;
use Api\PaymentMethod\Domain\ValueObjects\PostalCode;
use Api\PaymentMethod\Domain\ValueObjects\SalesRepEmployeeNumber;
use Api\PaymentMethod\Domain\ValueObjects\State;

final class PaymentMethod
{
    private function __construct(
        private PaymentMethodNumber $paymentMethodNumber,
        private NameMethod $nameMethod,
        private ?DescriptioMethod $descriptioMethod = null
    ) {
    }

    public static function create(
        PaymentMethodNumber $paymentMethodNumber,
        NameMethod $nameMethod,
        ?DescriptioMethod $descriptioMethod = null
    ) {
        return new self(
            $paymentMethodNumber,
            $nameMethod,
            $descriptioMethod
        );
    }

    /**
     * Get the value of paymentMethodNumber
     */
    public function paymentMethodNumber(): PaymentMethodNumber
    {
        return $this->paymentMethodNumber;
    }

    /**
     * Set the value of paymentMethodNumber
     *
     * @return  void
     */
    public function updatePaymentMethodNumber(int $paymentMethodNumber): void
    {
        $this->paymentMethodNumber = PaymentMethodNumber::fromInteger($paymentMethodNumber);
    }

    /**
     * Get the value of nameMethod
     */
    public function nameMethod(): NameMethod
    {
        return $this->nameMethod;
    }

    /**
     * Set the value of nameMethod
     *
     * @return  void
     */
    public function updateNameMethod(string $nameMethod): void
    {
        $this->nameMethod = NameMethod::fromString($nameMethod);
    }

    /**
     * Get the value of descriptioMethod
     */
    public function descriptioMethod(): ?DescriptioMethod
    {
        return $this->descriptioMethod;
    }

    /**
     * Set the value of descriptioMethod
     *
     * @return  void
     */
    public function updateDescriptioMethod(string $descriptioMethod): void
    {
        $this->descriptioMethod = DescriptioMethod::fromString($descriptioMethod);
    }



    public function asArray(): array
    {
        return [
            'paymentMethodNumber' => $this->paymentMethodNumber()->value(),
            'nameMethod' => $this->nameMethod()->value(),
            'descriptioMethod' => $this->descriptioMethod()?->value()
        ];
    }
}
