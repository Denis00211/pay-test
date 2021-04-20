<?php

namespace App\Repositories;

use App\Dto\Payments\PaymentListRequestDto;
use App\Dto\Payments\PaymentStoreDto;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PaymentRepository
{
    public function list(PaymentListRequestDto $dto): LengthAwarePaginator
    {
        $limit = 15;

        return Payment::query()->select(['id', 'amount', 'uuid', 'status', 'created_date', 'payment_date'])
            ->where(['user_id' => $dto->getUserId()])
            ->when($dto->getAmount(), static function (Builder $query) use ($dto) {
                $query->where('amount', '=', $dto->getAmount());
            })
            ->when($dto->getUuid(), static function (Builder $query) use ($dto) {
                $query->where('uuid', '=', $dto->getUuid());
            })
            ->when($dto->getStatus(), static function (Builder $query) use ($dto) {
                $query->where('status', '=', $dto->getStatus());
            })
            ->paginate($limit);
    }

    /**
     * @param int $userId
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function show(int $userId, int $id)
    {
        return Payment::query()->where(['user_id' => $userId, 'id' => $id])->firstOrFail();
    }

    /**
     * @param \App\Dto\Payments\PaymentStoreDto $dto
     * @return bool
     */
    public function store(PaymentStoreDto $dto): bool
    {
        $payment = new Payment();

        $payment->amount = $payment->cutAmount($dto->getAmount(), 2);

        $payment->user_id = $dto->getUserId();
        $payment->status = Payment::STATUS_CREATED;
        $payment->created_date = date('Y-m-d H:i:s');
        $payment->uuid = Str::orderedUuid();

        if($dto->getEmail()) {
            $payment->email = $dto->getEmail();
        }
        if($dto->getPhone()) {
            $payment->phone = $dto->getPhone();
        }

        return $payment->save();
    }

    /**
     * @param string $uuid
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getPaymentByUuid(string  $uuid): ?Payment
    {
        return Payment::query()->where(['uuid' => $uuid])->first();
    }

    /**
     * @param \App\Models\Payment $payment
     * @return bool
     */
    public function saveFailedPay(Payment $payment): bool
    {
        $payment->status = Payment::STATUS_FAILED;
        return $payment->update([
            'status'
        ]);
    }

    public function saveSuccessPay(Payment $payment, string $cardNumber): bool
    {
        $payment->status = Payment::STATUS_SUCCESS;
        $payment->payment_date = date('Y-m-d H:i:s');

        $cardNumber = preg_replace('/[^\d]/','',$cardNumber);
        $payment->card_first_six = substr($cardNumber, 0, 6);
        $payment->card_last_four = substr($cardNumber, -4, 4);
        return $payment->update([
            'status',
            'payment_date',
            'card_first_six',
            'card_last_four'
        ]);
    }
}
