<?php

namespace App\Dto\Payments;

class PaymentStoreDto
{
    private int $userId;
    private float $amount;
    private ?string $phone;
    private ?string $email;

    public function __construct(int $userId, float $amount, ?string $phone, ?string $email)
    {
        $this->userId = $userId;
        $this->amount = $amount;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
