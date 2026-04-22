<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Admin\CronController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::redirect('/dashboard', '/admin/dashboard');

Route::prefix('admin')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::get('/crons', [CronController::class, 'index'])->name('admin.crons.index');
    Route::post('/crons/{taskKey}/run', [CronController::class, 'run'])->name('admin.crons.run');
});
