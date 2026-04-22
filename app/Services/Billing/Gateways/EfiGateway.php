<?php

namespace App\Services\Billing\Gateways;

use App\Contracts\Billing\GatewayContract;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;

class EfiGateway implements GatewayContract
{
    public function createCharge(Invoice $invoice, PaymentGatewayAccount $account): array
    {
        return [
            'gateway' => 'efi',
            'status' => 'pending',
            'reference' => $invoice->code,
            'message' => 'Integracao pendente de credenciais e SDK.',
        ];
    }

    public function processWebhook(array $payload, PaymentGatewayAccount $account): array
    {
        return [
            'gateway' => 'efi',
            'processed' => true,
            'payload' => $payload,
        ];
    }
}
