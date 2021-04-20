<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ];
    }
}
