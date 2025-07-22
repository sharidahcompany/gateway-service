<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\TenantController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware([
    'api', \App\Http\Middleware\SetLocaleFromHeader::class,
 ])->group(function () {
    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


    // PROTECTED ROUTES


    Route::middleware('auth:api')->group(function () {
        // User
        Route::apiResource('users', UserController::class);

        // Tenant
        Route::apiResource('tenants', TenantController::class)->only('store', 'show', 'update');

        // Logout
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
