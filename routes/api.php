<?php

use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\Tenant\CustomerController;
use App\Http\Controllers\Api\V1\WebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/health', HealthController::class);
    Route::get('/tenant/{tenant}/customers', [CustomerController::class, 'index']);
    Route::post('/webhooks/{tenant}/{gateway}', WebhookController::class);
});
