<?php

declare(strict_types=1);

namespace Api\Orders\Domain\Aggregate;

use Api\Customers\Domain\ValueObjects\CustomerNumber;
use Api\Orders\Domain\ValueObjects\Comments;
use Api\Orders\Domain\ValueObjects\OrderDate;
use Api\Orders\Domain\ValueObjects\OrderNumber;
use Api\Orders\Domain\ValueObjects\RequiredDate;
use Api\Orders\Domain\ValueObjects\ShippedDate;
use Api\Orders\Domain\ValueObjects\Status;

final class Order
{
    private function __construct(
        private OrderNumber $orderNumber,
        private OrderDate $orderDate,
        private RequiredDate $requiredDate,
        private Status $status,
        private CustomerNumber $customerNumber,
        private ?ShippedDate $shippedDate = null,
        private ?Comments $comments = null
    ) {
    }

    public static function create(
        OrderNumber $orderNumber,
        OrderDate $orderDate,
        RequiredDate $requiredDate,
        Status $status,
        CustomerNumber $customerNumber,
        ?ShippedDate $shippedDate = null,
        ?Comments $comments = null
    ) {
        return new self(
            $orderNumber,
            $orderDate,
            $requiredDate,
            $status,
            $customerNumber,
            $shippedDate,
            $comments
        );
    }

    /**
     * Get the value of orderNumber
     */
    public function orderNumber(): OrderNumber
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

    /**
     * Get the value of orderDate
     */
    public function orderDate(): OrderDate
    {
        return $this->orderDate;
    }

    /**
     * Set the value of orderDate
     *
     * @return  void
     */
    public function updateOrderDate(string $orderDate): void
    {
        $this->orderDate = OrderDate::fromPrimitives($orderDate);
    }

    /**
     * Get the value of requiredDate
     */
    public function requiredDate(): RequiredDate
    {
        return $this->requiredDate;
    }

    /**
     * Set the value of requiredDate
     *
     * @return  void
     */
    public function updateRequiredDate(string $requiredDate): void
    {
        $this->requiredDate = RequiredDate::fromPrimitives($requiredDate);
    }

    /**
     * Get the value of status
     */
    public function status(): Status
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  void
     */
    public function updateStatus(string $status): void
    {
        $this->status = Status::fromString($status);
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
     * Get the value of shippedDate
     */
    public function shippedDate(): ?ShippedDate
    {
        return $this->shippedDate;
    }

    /**
     * Set the value of shippedDate
     *
     * @return  void
     */
    public function updateShippedDate(string $shippedDate): void
    {
        $this->shippedDate = ShippedDate::fromPrimitives($shippedDate);
    }

    /**
     * Get the value of comments
     */
    public function comments(): ?Comments
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  void
     */
    public function updateComments(string $comments): void
    {
        $this->comments = Comments::fromString($comments);
    }

    public function asArray(): array
    {
        return [
            'orderNumber' => $this->orderNumber()->value(),
            'orderDate' => $this->orderDate()->value(),
            'requiredDate' => $this->requiredDate()->value(),
            'status' => $this->status()->value(),
            'customerNumber' => $this->customerNumber()->value(),
            'shippedDate' => $this->shippedDate()?->value(),
            'comments' => $this->comments()?->value()
        ];
    }
}
