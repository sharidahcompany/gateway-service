<?php

use App\Http\Controllers\v1\Central\AuthController;
use App\Http\Controllers\v1\Central\CountryController;
use App\Http\Controllers\v1\Central\CurrencyController;
use App\Http\Controllers\v1\Central\DiscountController;
use App\Http\Controllers\v1\Central\ExternalObservableController;
use App\Http\Controllers\v1\Central\ExternalObserverController;
use App\Http\Controllers\v1\Central\FeatureController;
use App\Http\Controllers\v1\Central\HomeController;
use App\Http\Controllers\v1\Central\PermissionController;
use App\Http\Controllers\v1\Central\PlanController;
use App\Http\Controllers\v1\Central\PrivilegeController;
use App\Http\Controllers\v1\Central\TenantController;
use App\Http\Controllers\v1\Central\ThemeController;
use App\Http\Controllers\v1\Central\UserController;
use App\Http\Middleware\SetLocaleFromHeader;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware([
    'api',
    SetLocaleFromHeader::class,
])->group(function () {

    //**********************************************************************************************/
    //get tenants for HR service becuse employees attendace
    Route::get('tenants', [TenantController::class, 'index']);

    //**********************************************************************************************/

    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('resend-otp', [AuthController::class, 'resend_otp']);
    Route::post('forgot-password', [AuthController::class, 'forgot_password']);
    Route::post('verify-otp', [AuthController::class, 'verify_otp']);
    Route::post('reset-password', [AuthController::class, 'reset_password']);
    Route::post('change-password', [AuthController::class, 'change_password']);
    Route::get('permissions', [PermissionController::class, 'index']);


    Route::apiResource('tenants', TenantController::class)->only('index', 'show');

    Route::get('countries', [CountryController::class, 'index']);
    Route::get('currencies', [CurrencyController::class, 'index']);


    Route::apiResource('plans', PlanController::class)->only('index');

    Route::apiResource('features', FeatureController::class)->only('index');

    Route::apiResource('privileges', PrivilegeController::class)->only('index');

    Route::apiResource('discounts', DiscountController::class)->only('index');

    Route::apiResource('themes', ThemeController::class)->only('index');

    Route::get('website-data', [HomeController::class, 'websiteData']);

    Route::middleware('auth:api')->group(function () {
        Route::get('home', [HomeController::class, 'index']);
        Route::delete('users', [UserController::class, 'destroy_bulk']);
        Route::get('me', [AuthController::class, 'me']);

        Route::post('external-observables/request-access', [ExternalObserverController::class, 'requestAccess']);
        Route::get('external-observables/outgoing-requests', [ExternalObserverController::class, 'outgoingRequests']);
        Route::get('external-observables/incoming-requests', [ExternalObserverController::class, 'incomingRequests']);
        Route::post('external-observables/requests/{request_id}/accept', [ExternalObserverController::class, 'acceptRequest']);
        Route::post('external-observables/requests/{request_id}/reject', [ExternalObserverController::class, 'rejectRequest']);
        Route::get('external-observables/subsidiaries', [ExternalObserverController::class, 'subsidiaries']);

        Route::post('users/email-confirmation', [AuthController::class, 'confirm_email']);
        Route::get('users/send-confirmation-email', [AuthController::class, 'send_confirmation_email']);
        Route::get('users/tenants', [UserController::class, 'tenants']);

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
