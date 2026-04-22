<?php

namespace App\Services\Billing\Gateways;

use App\Contracts\Billing\GatewayContract;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Support\Facades\Log;

class MercadoPagoGateway implements GatewayContract
{
    private string $accessToken;

    public function __construct(PaymentGatewayAccount $account)
    {
        $this->accessToken = decrypt($account->secret_key);
        MercadoPagoConfig::setAccessToken($this->accessToken);
    }

    public function createCharge(Invoice $invoice, PaymentGatewayAccount $account): array
    {
        try {
            $client = new PreferenceClient();

            $preference = $client->create([
                'items' => [
                    [
                        'id' => $invoice->id,
                        'title' => "Invoice #{$invoice->code}",
                        'description' => "Invoice from {$invoice->tenant->name}",
                        'quantity' => 1,
                        'unit_price' => (float) $invoice->total,
                    ],
                ],
                'payer' => [
                    'name' => $invoice->customer->name,
                    'email' => $invoice->customer->email,
                    'phone' => [
                        'number' => preg_replace('/[^0-9]/', '', $invoice->customer->phone ?? ''),
                    ],
                ],
                'back_urls' => [
                    'success' => route('invoice.payment-success', ['code' => $invoice->code]),
                    'failure' => route('invoice.payment-failure', ['code' => $invoice->code]),
                    'pending' => route('invoice.payment-pending', ['code' => $invoice->code]),
                ],
                'auto_return' => 'approved',
                'external_reference' => $invoice->code,
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'tenant_id' => $invoice->tenant_id,
                    'customer_id' => $invoice->customer_id,
                ],
            ]);

            return [
                'gateway' => 'mercadopago',
                'status' => 'pending',
                'reference' => $preference->id,
                'payment_url' => $preference->init_point,
                'message' => 'Preference created successfully',
            ];
        } catch (MPApiException $e) {
            Log::error("MercadoPago payment error: {$e->getMessage()}", [
                'invoice_id' => $invoice->id,
                'error' => $e->getApiResponse(),
            ]);

            return [
                'gateway' => 'mercadopago',
                'status' => 'failed',
                'reference' => null,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function processWebhook(array $payload, PaymentGatewayAccount $account): array
    {
        try {
            $type = $payload['type'] ?? null;
            $data = $payload['data'] ?? [];

            switch ($type) {
                case 'payment':
                    return $this->handlePaymentNotification($data);

                case 'plan':
                    return $this->handlePlanNotification($data);

                case 'subscription':
                    return $this->handleSubscriptionNotification($data);

                default:
                    return [
                        'gateway' => 'mercadopago',
                        'processed' => true,
                        'status' => 'ignored',
                        'message' => 'Notification type not handled',
                    ];
            }
        } catch (\Exception $e) {
            Log::error("MercadoPago webhook processing error: {$e->getMessage()}", [
                'payload' => $payload,
            ]);

            return [
                'gateway' => 'mercadopago',
                'processed' => false,
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    private function handlePaymentNotification(array $data): array
    {
        $paymentId = $data['id'] ?? null;
        $externalReference = $data['external_reference'] ?? null;

        if (!$externalReference) {
            return [
                'gateway' => 'mercadopago',
                'processed' => false,
                'status' => 'error',
                'message' => 'Missing external reference',
            ];
        }

        $invoice = Invoice::where('code', $externalReference)->first();

        if (!$invoice) {
            return [
                'gateway' => 'mercadopago',
                'processed' => false,
                'status' => 'error',
                'message' => 'Invoice not found',
            ];
        }

        $status = $data['status'] ?? null;

        switch ($status) {
            case 'approved':
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => 'mercadopago',
                    'payment_reference' => $paymentId,
                ]);
                break;

            case 'rejected':
                $invoice->update([
                    'status' => 'failed',
                    'payment_reference' => $paymentId,
                ]);
                break;

            case 'pending':
                $invoice->update([
                    'status' => 'pending',
                    'payment_reference' => $paymentId,
                ]);
                break;

            case 'cancelled':
                $invoice->update([
                    'status' => 'cancelled',
                    'payment_reference' => $paymentId,
                ]);
                break;

            case 'refunded':
                $invoice->update([
                    'status' => 'refunded',
                    'payment_reference' => $paymentId,
                ]);
                break;
        }

        return [
            'gateway' => 'mercadopago',
            'processed' => true,
            'status' => $status,
            'message' => 'Payment notification processed',
        ];
    }

    private function handlePlanNotification(array $data): array
    {
        return [
            'gateway' => 'mercadopago',
            'processed' => true,
            'status' => 'ignored',
            'message' => 'Plan notification received',
        ];
    }

    private function handleSubscriptionNotification(array $data): array
    {
        return [
            'gateway' => 'mercadopago',
            'processed' => true,
            'status' => 'ignored',
            'message' => 'Subscription notification received',
        ];
    }
}
