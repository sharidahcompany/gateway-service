<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\CountryController;
use App\Http\Controllers\v1\CurrencyController;
use App\Http\Controllers\v1\DiscountController;
use App\Http\Controllers\v1\FeatureController;
use App\Http\Controllers\v1\PlanController;
use App\Http\Controllers\v1\PrivilegeController;
use App\Http\Controllers\v1\TenantController;
use App\Http\Controllers\v1\ThemeController;
use App\Http\Controllers\v1\UserController;
use App\Http\Middleware\SetLocaleFromHeader;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware([
    'api',
    SetLocaleFromHeader::class,
])->group(function () {
    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgot_password']);
    Route::post('verify-otp', [AuthController::class, 'verify_otp']);
    Route::post('reset-password', [AuthController::class, 'reset_password']);

    Route::apiResource('tenants', TenantController::class)->only('index', 'show');

    Route::get('countries', [CountryController::class, 'index']);
    Route::get('currencies', [CurrencyController::class, 'index']);


    Route::apiResource('plans', PlanController::class)->only('index');

    Route::apiResource('features', FeatureController::class)->only('index');

    Route::apiResource('privileges', PrivilegeController::class)->only('index');

    Route::apiResource('discounts', DiscountController::class)->only('index');

    Route::apiResource('themes', ThemeController::class)->only('index');

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::delete('users', [UserController::class, 'destroy_bulk']);

        Route::post('users/email-confirmation', [AuthController::class, 'confirm_email']);
        Route::get('users/send-confirmation-email', [AuthController::class, 'send_confirmation_email']);
        Route::get('users/tenants', [UserController::class, 'tenants']);
        Route::apiResource('users', UserController::class);


        Route::post('tenants/upload-logo', [TenantController::class, 'upload_logo']);
        Route::post('tenants/delete-logo', [TenantController::class, 'delete_logo']);
        Route::apiResource('tenants', TenantController::class)->except('index', 'show');


        Route::delete('tenants', [TenantController::class, 'destroy_bulk']);

        Route::apiResource('plans', PlanController::class)->except('index');

        Route::apiResource('features', FeatureController::class)->except('index');

        Route::apiResource('privileges', PrivilegeController::class)->except('index');

        Route::apiResource('discounts', DiscountController::class)->except('index');
        Route::delete('discounts', [DiscountController::class, 'destroy_bulk']);

        Route::apiResource('themes', ThemeController::class)->except('index');

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
