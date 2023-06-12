<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'name' =>'required|string|min:3|max:255',
            'email' => 'required|email|unique:users|min:3|max:255',
            'password' => 'required|min:3|max:20|confirmed',
            'password_confirmation' => 'required|min:3|max:20',
        ];
    }
}
