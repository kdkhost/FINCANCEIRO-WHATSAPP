<?php

namespace App\Contracts\Billing;

use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;

interface GatewayContract
{
    public function createCharge(Invoice $invoice, PaymentGatewayAccount $account): array;

    public function processWebhook(array $payload, PaymentGatewayAccount $account): array;
}
