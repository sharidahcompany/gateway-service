<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\FeatureController;
use App\Http\Controllers\v1\PlanController;
use App\Http\Controllers\v1\PrivilegeController;
use App\Http\Controllers\v1\TenantController;
use App\Http\Controllers\v1\UserController;
use App\Http\Middleware\InitializeTenantFromHeader;
use App\Http\Middleware\SetLocaleFromHeader;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware([
    'api',
    SetLocaleFromHeader::class,
    InitializeTenantFromHeader::class,
 ])->group(function () {
    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::apiResource('plans', PlanController::class)->only('index');

    Route::apiResource('features', FeatureController::class)->only('index');

    Route::apiResource('privileges', PrivilegeController::class)->only('index');


    // PROTECTED ROUTES


    Route::middleware('auth:api')->group(function () {
        Route::apiResource('users', UserController::class);

        Route::apiResource('tenants', TenantController::class)->only('store', 'update', 'destroy');

        Route::apiResource('plans', PlanController::class)->except('index');

        Route::apiResource('features', FeatureController::class)->except('index');

        Route::apiResource('privileges', PrivilegeController::class)->except('index');

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
