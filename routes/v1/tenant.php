<?php

declare(strict_types=1);

use App\Http\Controllers\v1\EmployeeController;
use App\Http\Controllers\v1\HomeController;
use App\Http\Controllers\v1\UserController;
use App\Http\Middleware\InitializeTenantFromHeader;
use App\Http\Middleware\ProxyRequest;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->middleware('api')->middleware(InitializeTenantFromHeader::class)->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('employees/invite', [EmployeeController::class, 'invite']);
    Route::get('reports', [HomeController::class, 'reports']);

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
