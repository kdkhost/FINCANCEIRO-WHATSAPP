<?php

namespace App\Services\Billing\Gateways;

use App\Contracts\Billing\GatewayContract;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeGateway implements GatewayContract
{
    private string $secretKey;

    public function __construct(PaymentGatewayAccount $account)
    {
        $this->secretKey = decrypt($account->secret_key);
        Stripe::setApiKey($this->secretKey);
    }

    public function createCharge(Invoice $invoice, PaymentGatewayAccount $account): array
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($invoice->total * 100), // Stripe usa centavos
                'currency' => 'brl',
                'description' => "Invoice #{$invoice->code}",
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'tenant_id' => $invoice->tenant_id,
                    'customer_id' => $invoice->customer_id,
                ],
                'statement_descriptor' => substr($invoice->tenant->name, 0, 22),
            ]);

            return [
                'gateway' => 'stripe',
                'status' => 'pending',
                'reference' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret,
                'payment_url' => "https://stripe.com/pay/{$paymentIntent->client_secret}",
                'message' => 'Payment intent created successfully',
            ];
        } catch (ApiErrorException $e) {
            Log::error("Stripe payment error: {$e->getMessage()}", [
                'invoice_id' => $invoice->id,
                'error' => $e->getError(),
            ]);

            return [
                'gateway' => 'stripe',
                'status' => 'failed',
                'reference' => null,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function processWebhook(array $payload, PaymentGatewayAccount $account): array
    {
        try {
            $event = $payload;

            switch ($event['type'] ?? null) {
                case 'payment_intent.succeeded':
                    return $this->handlePaymentSucceeded($event['data']['object'] ?? []);

                case 'payment_intent.payment_failed':
                    return $this->handlePaymentFailed($event['data']['object'] ?? []);

                case 'charge.refunded':
                    return $this->handleRefund($event['data']['object'] ?? []);

                default:
                    return [
                        'gateway' => 'stripe',
                        'processed' => true,
                        'status' => 'ignored',
                        'message' => 'Event type not handled',
                    ];
            }
        } catch (\Exception $e) {
            Log::error("Stripe webhook processing error: {$e->getMessage()}", [
                'payload' => $payload,
            ]);

            return [
                'gateway' => 'stripe',
                'processed' => false,
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    private function handlePaymentSucceeded(array $paymentIntent): array
    {
        $invoiceId = $paymentIntent['metadata']['invoice_id'] ?? null;

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => 'stripe',
                    'payment_reference' => $paymentIntent['id'],
                ]);
            }
        }

        return [
            'gateway' => 'stripe',
            'processed' => true,
            'status' => 'success',
            'message' => 'Payment succeeded',
        ];
    }

    private function handlePaymentFailed(array $paymentIntent): array
    {
        $invoiceId = $paymentIntent['metadata']['invoice_id'] ?? null;

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'failed',
                    'payment_reference' => $paymentIntent['id'],
                ]);
            }
        }

        return [
            'gateway' => 'stripe',
            'processed' => true,
            'status' => 'failed',
            'message' => 'Payment failed',
        ];
    }

    private function handleRefund(array $charge): array
    {
        $invoiceId = $charge['metadata']['invoice_id'] ?? null;

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'refunded',
                    'payment_reference' => $charge['id'],
                ]);
            }
        }

        return [
            'gateway' => 'stripe',
            'processed' => true,
            'status' => 'refunded',
            'message' => 'Refund processed',
        ];
    }
}
