<?php

declare(strict_types=1);

use App\Http\Controllers\v1\Central\EmployeeController;
use App\Http\Controllers\v1\Central\HomeController;
use App\Http\Controllers\v1\Central\TenantController;
use App\Http\Controllers\v1\Central\UserController;
use App\Http\Controllers\v1\Tenant\AuthController;
use App\Http\Middleware\InitializeTenantFromHeader;
use App\Http\Middleware\ProxyRequest;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->middleware('api')->middleware(InitializeTenantFromHeader::class)->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('resend-otp', [AuthController::class, 'resend_otp']);
    Route::post('forgot-password', [AuthController::class, 'forgot_password']);
    Route::post('verify-otp', [AuthController::class, 'verify_otp']);
    Route::post('reset-password', [AuthController::class, 'reset_password']);
    Route::post('change-password', [AuthController::class, 'change_password']);
    Route::apiResource('users', UserController::class);
    Route::post('employees/invite', [EmployeeController::class, 'invite']);
    Route::get('reports', [HomeController::class, 'reports']);

    Route::middleware('auth:api')->group(function () {
        Route::post('tenants/upload-logo', [TenantController::class, 'upload_logo']);
        Route::post('tenants/delete-logo', [TenantController::class, 'delete_logo']);
        Route::post('tenants/switch', [TenantController::class, 'switch']);
    });

    $services = [
        'accounting' => 'http://accounting-web/api/v1',
        'project-management' => 'http://pm-web/api/v1',
        'hr' => 'http://hr-web/api/v1',
        'workforce' => 'http://workforce-web/api/v1',
        'buffet' => 'http://buffet-web/api/v1',
        'ws' => 'http://website-setting-web/api/v1',
    ];

    foreach ($services as $prefix => $url) {
        Route::any("$prefix/{path?}", fn() => null)
            ->where('path', '.*')
            ->middleware([ProxyRequest::class . ":$url"]);
    }
});
