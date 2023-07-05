<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method_id' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'billing_address' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_zip' => 'required|string|max:255',
            'card_holder' => 'required|string|max:255',
        ];
    }
}

