<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Resources\MeUserResource;
use App\Http\Resources\UserResource;
use App\Http\Services\v1\UserService;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use App\Models\OTP;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserEmailConfirmMail;
use Illuminate\Support\Facades\Http;
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

    public function me(Request $request)
    {
        $tenantId = $request->header('X-Tenant');
        $token = $request->bearerToken();
        $user = Auth::user();

        if(!$user->hasVerifiedEmail()){
            return response()->json([
            'message' => trans('auth.email_not_verified'),
            'verified'=>false
            ], 401);
        }    

        $response = Http::withToken($token)->withHeaders([
            'X-Tenant' => $tenantId,
        ])->get('http://workforce-web/api/v1/me');

        if ($response->failed()) {
            return response()->json([
                'message' => 'HR service error',
            ], 500);
        }

       
        $hrData = $response->json();             

        return response()->json([
                'data' => new MeUserResource([
                    'user' => $user,
                    'hr' => $hrData
                ]),
            ]);
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
        $user = $this->user_service->find(auth('api')->user()->id);

        event(new UserCreated($user));

        return response()->json([
            'message' => trans('auth.confirm.sent'),
            'verified'=>true,
        ]);
    }


    public function resend_otp(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->validated('email'))->first();

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
            $user  = User::where('email', $request->validated('email'))->first();
            $this->checkExpiredOtp($user);
            return response()->json([
                'message' => trans('auth.otp_sent'),
            ], 200);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }




    public function verify_otp(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp'   => 'required|digits:6',
            ]);

            $user = User::where('email', $request->email)->first();

            $otpRecord = OTP::where('user_id', $user->id)
                ->where('otp', $request->otp)
                ->where('expired_at', '>', now())
                ->first();

            if (!$otpRecord) {
                return response()->json([
                    'message' => trans('auth.otp_invalid')
                ], 422);
            }

            // $otpRecord->delete();

            $token = Str::random(60);

            cache()->put("reset_token_{$user->id}", $token, now()->addMinutes(10));

            return response()->json([
                'message' => trans('auth.otp_verified'),
                'reset_token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }



    public function reset_password(Request $request)
    {
        try {

            $request->validate([
                'email'    => 'required|email|exists:users,email',
                'password' => 'required|min:8|confirmed',
            ]);

            $user = User::where('email', $request->email)->first();

            $token = $request->bearerToken();

            $cachedToken = cache()->get("reset_token_{$user->id}");

            if (!$cachedToken || $cachedToken !== $token) {
                return response()->json([
                    'message' => trans('auth.reset_token_invalid')
                ], 422);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            cache()->forget("reset_token_{$user->id}");
            OTP::where('user_id', $user->id)->delete();

            return response()->json([
                'message' => trans('auth.password_reset.success')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }



    private function checkExpiredOtp($user)
    {
        $lastOtp = OTP::where('user_id', $user->id)
            ->where('expired_at', '>', now())
            ->first();
        if ($lastOtp) {
            throw new Exception(trans('auth.otp_already_sent'));
        }
        $otp = $this->generateOtp($user);
        return $this->sendMail($user->email, $user, $otp);
    }


    private function generateOtp($user)
    {
        $otp = rand(100000, 999999);
        OTP::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expired_at' => now()->addSeconds(60),
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
    private function sendMail($email, $user, $otp)
    {
        Mail::to($email)->send(new ForgotPasswordMail($user, $otp));
        return response()->json([
            'message' => trans('auth.otp_sent')
        ], 200);
    }



    public function change_password(ChangePasswordRequest $request)
    {



        try {

            $user = auth('api')->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'message' => trans('auth.password.current_incorrect')
                ], 422);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            $user->save();

            return response()->json([
                'message' =>  trans('auth.password.changed_successfully')
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
