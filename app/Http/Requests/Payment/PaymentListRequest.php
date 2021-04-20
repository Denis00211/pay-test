<?php

namespace App\Http\Requests\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentListRequest
{
    private ?MessageBag $errors;

    /**
     * @return array|null[]
     */
    public function validate(): array
    {
        $validator = Validator::make(
            Request::all(),
            [
                'amount' => ['nullable', 'numeric', 'min:0'],
                'uuid' => ['nullable', 'string', 'max:36'],
                'status' => [
                    'nullable',
                    'integer',
                    Rule::in(array_keys(Payment::getStatuses())),
                ],
            ]
        );
        try {
            $filter = $validator->validated();
        } catch (ValidationException $e) {
            $filter = [];
        }

        $amount = $filter['amount']??null;
        $uuid = $filter['uuid']??null;
        $status = $filter['status']??null;

        $this->errors = $validator->fails() ? $validator->errors() : null;

        return [
            $amount,
            $uuid,
            $status,
        ];
    }

    public function getErrors(): ?MessageBag
    {
        return $this->errors;
    }
}
