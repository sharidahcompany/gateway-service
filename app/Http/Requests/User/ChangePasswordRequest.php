<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }

   public function messages()
{
    return [
        'current_password.required' => __('auth.current_password_required'),
        'new_password.required' => __('auth.new_password_required'),
        'new_password.min' => __('auth.new_password_min'),
        'new_password.confirmed' => __('auth.new_password_confirmed'),
    ];
}

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first()
        ], 422));
    }
}
