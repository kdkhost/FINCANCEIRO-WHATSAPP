<?php

namespace App\Services\Billing\Gateways;

use App\Contracts\Billing\GatewayContract;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;

class StripeGateway implements GatewayContract
{
    public function createCharge(Invoice $invoice, PaymentGatewayAccount $account): array
    {
        return [
            'gateway' => 'stripe',
            'status' => 'pending',
            'reference' => $invoice->code,
            'message' => 'Integracao pendente de credenciais e SDK.',
        ];
    }

    public function processWebhook(array $payload, PaymentGatewayAccount $account): array
    {
        return [
            'gateway' => 'stripe',
            'processed' => true,
            'payload' => $payload,
        ];
    }
}
