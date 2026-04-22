<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendWhatsappMessageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $tenantId,
        public string $phone,
        public string $message
    ) {
    }

    public function handle(): void
    {
        // Integracao com Evolution API sera conectada apos instalacao dos pacotes e credenciais.
    }
}
