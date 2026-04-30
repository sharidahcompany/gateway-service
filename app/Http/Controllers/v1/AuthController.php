<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\v1\UserService;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\OTP;
use App\Mail\UserEmailConfirmMail;

use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct(protected UserService $user_service) {}

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = $this->user_service->create($data);

        $token = auth('api')->login($user);

        event(new UserCreated($user));

        // $cookie = cookie('auth_token', $token, 60 * 24, '/', null, true, true, false, 'Lax');
        $cookie = cookie(
            'auth_token',
            $token,
            60 * 24,
            '/',
            null,
            false,
            true,
            false,
            null
        );

        return (new UserResource($user))
            ->additional([
                'token' => $token,
                'message' => trans('auth.register.success'),
            ])
            ->response()
            ->withCookie($cookie)
            ->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        $creds = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($creds)) {
            return response()->json([
                'message' => trans('auth.failed')
            ], 401);
        }

        $user = auth('api')->user();

        $tenant = $user->tenants()->first();
        $tenantId = $tenant?->id;

        $cookie = cookie(
            'auth_token',
            $token,
            60 * 24,
            '/',
            null,
            true,
            true,
            false,
            'Lax'
        );

        return (new UserResource($user))
            ->additional([
                'message' => trans('auth.login.success'),
                'token' => $token,
                'tenant_id' => $tenantId,
            ])
            ->response()
            ->withCookie($cookie)
            ->setStatusCode(200);
    }

    public function me()
    {
        return (new UserResource(auth('api')->user()))
            ->response()
            ->setStatusCode(200);
    }

    public function logout()
    {
        auth('api')->logout();

        $cookie = Cookie::forget('auth_token');

        return response()->json([
            'message' => trans('auth.logout.success')
        ], 200)->withCookie($cookie);
    }


    public function confirm_email(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'otp' => 'required|string',
        ]);

        $validated['user_id'] = $user['id'];

        $status = $this->user_service->confirm_email($validated);

        return match ($status) {
            'invalid' => response()->json(['message' => trans('user.confirm.invalid')], 400),
            'expired' => response()->json(['message' => trans('user.confirm.expired')], 400),
            'success' => response()->json(['message' => trans('user.confirm.success')], 200),
        };
    }

    public function send_confirmation_email()
    {
        $user = $this->user_service->find(auth('api')->id());

        event(new UserCreated($user));

        return response()->json(['message' => trans('auth.confirm.sent')], 200);
    }


    public function resend_otp()
{
    $user = auth('api')->user();
    try {
        $mail = new UserEmailConfirmMail($user);
        $code = $mail->code;

        Mail::to($user->email)->send($mail);

        return response()->json([
            'message' => trans('auth.otp_sent')
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 429);
    }
}
    public function forgot_password(ForgotPasswordRequest $request)
    {


        try {
            $user = $this->user_service->findByEmail($request->email);

            $this->checkOtp($user->id);
            $otp = $this->generateOtp($user->id);
            return $this->sendMail($request->validated('email'),$user, $otp);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    public function reset_password(ResetPasswordRequest $request)
    {

        try {

            $user = $this->user_service->findByEmail($request->email);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            $user->save();

            return response()->json([
                'message' => trans('auth.password_reset.success')
            ], 200);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    private function generateOtp($userID)
    {
        $otp = rand(100000, 999999);
        OTP::create([
            'user_id' => $userID,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(2),
        ]);
        return $otp;
    }

    private function checkOtp($userID)
    {
        $lastOtp = OTP::where('user_id', $userID)
                ->where('expired_at', '>', now())
                ->first();

        if ($lastOtp) {
            throw new Exception(trans('auth.otp_already_sent'));
        }
    }
    private function sendMail($email,$user,$otp)
    {
        Mail::to($email)->send(new ForgotPasswordMail($user,$otp));
        return response()->json([
            'message' => trans('auth.otp_sent')
        ], 200);
    }

}
