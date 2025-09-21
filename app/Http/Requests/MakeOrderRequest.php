<?php

namespace App\Http\Requests;

use App\Http\Trait\ApiValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MakeOrderRequest extends FormRequest
{
    use ApiValidationResponse;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
