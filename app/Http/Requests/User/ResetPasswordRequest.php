<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\OTP;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|confirmed|min:8',
        ];
    }

   public function messages(): array
{
    return [
        'email.required' => __('auth.email_required'),
        'email.email' => __('auth.email_invalid'),
        'email.exists' => __('auth.email_not_found'),

        'otp.required' => __('auth.otp_required'),
        'otp.digits' => __('auth.otp_digits'),

        'password.required' => __('auth.password_required'),
        'password.confirmed' => __('auth.password_confirmed'),
        'password.min' => __('auth.password_min'),
    ];
}

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $user = User::where('email', $this->email)->first();

            if (!$user) {
                return;
            }

            $otpRecord = OTP::where('user_id', $user->id)
                ->latest()
                ->first();

            if (!$otpRecord) {
                $validator->errors()->add('otp', trans('auth.otp_not_found'));
                return;
            }

            if ($otpRecord->otp != $this->otp) {
                $validator->errors()->add('otp', trans('auth.otp_invalid'));
                return;
            }

            if ($otpRecord->expired_at->lt(now())) {
                $validator->errors()->add('otp', trans('auth.otp_expired'));
                return;
            }
        });
    }
}
