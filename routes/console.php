<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('financeiro:cron-status', function (): void {
    $this->comment('Cron interno do Financeiro Pro Whats operacional.');
});

Schedule::command('financeiro:cron-status')->everyMinute();
Schedule::command('financeiro:run-internal-cron')->everyMinute();
