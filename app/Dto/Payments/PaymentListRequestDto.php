<?php


namespace App\Dto\Payments;


class PaymentListRequestDto
{
    private int $userId;
    private ?float $amount;
    private ?string $uuid;
    private ?int $status;

    public function __construct(
        int $userId,
        ?float $amount,
        ?string $uuid,
        ?int $status
    )
    {
        $this->userId = $userId;
        $this->amount = $amount;
        $this->uuid = $uuid;
        $this->status = $status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
