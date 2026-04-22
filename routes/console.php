<?php

use App\Services\Cron\CronTaskRunner;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('financeiro:cron-status', function (): void {
    $this->comment('Cron interno do Financeiro Pro Whats operacional.');
});

Schedule::call(fn () => app(CronTaskRunner::class)->run('system.health-check', 'scheduler'))->everyMinute();
Schedule::call(fn () => app(CronTaskRunner::class)->run('system.internal-runner', 'scheduler'))->everyMinute();
Schedule::call(fn () => app(CronTaskRunner::class)->run('billing.reminders', 'scheduler'))->everyFiveMinutes();
Schedule::call(fn () => app(CronTaskRunner::class)->run('messaging.dispatch', 'scheduler'))->everyMinute();
Schedule::call(fn () => app(CronTaskRunner::class)->run('maintenance.cleanup', 'scheduler'))->daily();
