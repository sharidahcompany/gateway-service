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
            'password' => 'required|confirmed|min:8',
        ];
    }



    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {

    //         $user = User::where('email', $this->email)->first();

    //         if (!$user) {
    //             return;
    //         }

    //         $otpRecord = OTP::where('user_id', $user->id)
    //             ->latest()
    //             ->first();

    //         if (!$otpRecord) {
    //             $validator->errors()->add('otp', trans('auth.otp_not_found'));
    //             return;
    //         }

    //         if ($otpRecord->otp != $this->otp) {
    //             $validator->errors()->add('otp', trans('auth.otp_invalid'));
    //             return;
    //         }

    //         if ($otpRecord->expired_at->lt(now())) {
    //             $validator->errors()->add('otp', trans('auth.otp_expired'));
    //             return;
    //         }
    //     });
    // }
}
