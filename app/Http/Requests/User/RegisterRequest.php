<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone')) {
            $phone = $this->phone;

            // تنظيف الرقم من أي رموز
            $phone = preg_replace('/[^\d]/', '', $phone);

            // إضافة +
            if (!str_starts_with($phone, '+')) {
                $phone = '+' . $phone;
            }

            $this->merge([
                'phone' => $phone,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\p{L}\s]+$/u'],
            'last_name'  => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\p{L}\s]+$/u'],
            'username' => ['required', 'string', 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9._-]+$/u', 'min:3', 'max:50', 'unique:users,username'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'      => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password'   => ['required', 'string', 'confirmed', 'min:8', 'regex:/^[A-Za-z0-9@#$%^&*!]+$/'],
            'status'     => ['sometimes', 'in:active,inactive'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();


        $flatErrors = collect($errors)->flatten()->values();

        if ($flatErrors->count() > 1) {
            throw new HttpResponseException(response()->json([
                'message' => __('validation.too_many_errors'),
                'errors' => $errors,
            ], 422));
        }

        throw new HttpResponseException(response()->json([
            'message' => $flatErrors->first(),
            'errors' => $errors,
        ], 422));
    }


    public function messages()
    {
        return [
            'phone.phone' => __('user.phone_invalid'),
            'password.min' => __('validation.password_min'),

        ];
    }
}
