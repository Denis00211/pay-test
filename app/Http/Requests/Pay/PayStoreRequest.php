<?php

namespace App\Http\Requests\Pay;

use Illuminate\Foundation\Http\FormRequest;

class PayStoreRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'cardNumber' => ['required', 'string', 'min:16', 'max:16'],
            'cardMonth' => ['required', 'string', 'min:1', 'max:12'],
            'cardYear' => ['required', 'integer', 'min:' . date('Y')],
        ];
    }
}
