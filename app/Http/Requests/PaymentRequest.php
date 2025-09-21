<?php

namespace App\Http\Requests;

use App\Http\Trait\ApiValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentRequest extends FormRequest
{
    use ApiValidationResponse;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:wallet,card,cash',
        ];
    }
}
