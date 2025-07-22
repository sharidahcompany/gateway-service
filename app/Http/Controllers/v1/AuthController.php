<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\v1\UserService;

class AuthController extends Controller
{
    public  function __construct(protected UserService $user_service)
    {
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->user_service->create($data);

        $token = auth('api')->attempt($request->only('email','password'));

        return (new UserResource($user))
            ->additional([
                'token' => $token,
                'message' => trans('auth.register.success'),
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => trans('auth.failed')], 401);
        }

        $user = auth('api')->user();

        return (new UserResource($user))
            ->additional(['message' => trans('auth.login.success'), 'token' => $token])
            ->response()
            ->setStatusCode(200);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => trans('auth.logout.success')
        ], 200);
    }
}
