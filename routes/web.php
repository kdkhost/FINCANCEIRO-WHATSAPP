<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\CronController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\WebhookLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::redirect('/dashboard', '/admin/dashboard');

Route::prefix('admin')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AuthController::class, 'create'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'store'])->name('admin.login.store');
    });

    Route::middleware(['saas.admin', 'admin.ip'])->group(function (): void {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
        Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
        Route::get('/crons', [CronController::class, 'index'])->name('admin.crons.index');
        Route::post('/crons/{taskKey}/run', [CronController::class, 'run'])->name('admin.crons.run');

        Route::get('/tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
        Route::post('/tenants', [TenantController::class, 'store'])->name('admin.tenants.store');
        Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('admin.tenants.update');
        Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('admin.tenants.destroy');

        Route::get('/clientes', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::post('/clientes', [CustomerController::class, 'store'])->name('admin.customers.store');
        Route::put('/clientes/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('/clientes/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

        Route::get('/cobrancas', [InvoiceController::class, 'index'])->name('admin.invoices.index');
        Route::post('/cobrancas', [InvoiceController::class, 'store'])->name('admin.invoices.store');
        Route::put('/cobrancas/{invoice}', [InvoiceController::class, 'update'])->name('admin.invoices.update');
        Route::delete('/cobrancas/{invoice}', [InvoiceController::class, 'destroy'])->name('admin.invoices.destroy');

        Route::get('/gateways', [GatewayController::class, 'index'])->name('admin.gateways.index');
        Route::post('/gateways', [GatewayController::class, 'store'])->name('admin.gateways.store');
        Route::put('/gateways/{gateway}', [GatewayController::class, 'update'])->name('admin.gateways.update');
        Route::delete('/gateways/{gateway}', [GatewayController::class, 'destroy'])->name('admin.gateways.destroy');

        Route::get('/templates', [TemplateController::class, 'index'])->name('admin.templates.index');
        Route::post('/templates/whatsapp', [TemplateController::class, 'storeWhatsapp'])->name('admin.templates.whatsapp.store');
        Route::put('/templates/whatsapp/{whatsappTemplate}', [TemplateController::class, 'updateWhatsapp'])->name('admin.templates.whatsapp.update');
        Route::delete('/templates/whatsapp/{whatsappTemplate}', [TemplateController::class, 'destroyWhatsapp'])->name('admin.templates.whatsapp.destroy');
        Route::post('/templates/email', [TemplateController::class, 'storeEmail'])->name('admin.templates.email.store');
        Route::put('/templates/email/{emailTemplate}', [TemplateController::class, 'updateEmail'])->name('admin.templates.email.update');
        Route::delete('/templates/email/{emailTemplate}', [TemplateController::class, 'destroyEmail'])->name('admin.templates.email.destroy');

        Route::get('/webhooks/logs', [WebhookLogController::class, 'index'])->name('admin.webhooks.logs.index');
    });
});
