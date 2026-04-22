<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendBillingReminderJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $invoiceId
    ) {
    }

    public function handle(): void
    {
        // A logica de lembretes sera orquestrada por templates, e-mail e WhatsApp.
    }
}
