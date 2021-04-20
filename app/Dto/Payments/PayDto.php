<?php

namespace App\Dto\Payments;

use App\Models\Payment;

class PayDto
{
    private string $cardNumber;
    private string $cardMonth;
    private int $cardYear;
    private Payment $payment;

    public function __construct(Payment $payment, string $cardNumber, string $cardMonth, int $cardYear)
    {
        $this->payment = $payment;
        $this->cardNumber = $cardNumber;
        $this->cardMonth = $cardMonth;
        $this->cardYear = $cardYear;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function getCardMonth(): string
    {
        return $this->cardMonth;
    }

    public function getCardYear(): int
    {
        return $this->cardYear;
    }
}
