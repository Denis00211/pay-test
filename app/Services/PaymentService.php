<?php

namespace App\Services;

use App\Dto\Payments\PayDto;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Validators\CardValidator;

class PaymentService
{
    private PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function checkPaid(Payment $payment): bool
    {
        return $payment->checkPaid();
    }

    public function pay(PayDto $dto): bool
    {
        $validator = new CardValidator($dto->getCardNumber(), $dto->getCardMonth(), $dto->getCardYear());

        $payment = $dto->getPayment();
        if(!$isValidated = $validator->validate()) {
            $this->repository->saveFailedPay($payment);
        } else {
            $this->repository->saveSuccessPay($payment, $dto->getCardNumber());
        }

        return $isValidated;
    }
}
