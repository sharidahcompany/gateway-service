<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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

            // 1. تنظيف الرقم من أي مسافات أو رموز بالخطأ
            $phone = preg_replace('/[^\d]/', '', $phone);

            // 2. إذا كان الرقم لا يبدأ بـ +، قم بإضافتها يدوياً
            if (!str_starts_with($phone, '+')) {
                $phone = '+' . $phone;
            }

            // 3. دمج القيمة الجديدة في الـ Request
            $this->merge([
                'phone' => $phone,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/u'],
            'last_name'  => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/u'],
            'username'   => ['required', 'string', 'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/u', 'min:3', 'max:255', 'unique:users,username'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => [
                'required',
                'string',
                'max:20',
                'phone:AUTO,INTERNATIONAL', // ستعمل الآن لأن الرقم أصبح يبدأ بـ +
                'unique:users,phone'
            ],
            'password'   => ['required', 'string', 'confirmed', 'min:8'],
            'status'     => ['sometimes', 'in:active,inactive'],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone' => __('user.phone_invalid'),
        ];
    }
}