<?php

namespace App\Services\Billing\Gateways;

use App\Contracts\Billing\GatewayContract;
use App\Models\Invoice;
use App\Models\PaymentGatewayAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EfiGateway implements GatewayContract
{
    private string $clientId;
    private string $clientSecret;
    private const API_URL = 'https://api.gerencianet.com.br';

    public function __construct(PaymentGatewayAccount $account)
    {
        $this->clientId = decrypt($account->public_key);
        $this->clientSecret = decrypt($account->secret_key);
    }

    public function createCharge(Invoice $invoice, PaymentGatewayAccount $account): array
    {
        try {
            $token = $this->getAccessToken();

            if (!$token) {
                throw new \Exception('Failed to obtain access token');
            }

            $response = Http::withToken($token)
                ->post("{$this->API_URL}/v1/charge", [
                    'customer' => [
                        'name' => $invoice->customer->name,
                        'email' => $invoice->customer->email,
                        'cpf' => preg_replace('/[^0-9]/', '', $invoice->customer->document ?? ''),
                        'phone_number' => preg_replace('/[^0-9]/', '', $invoice->customer->phone ?? ''),
                    ],
                    'items' => [
                        [
                            'name' => "Invoice #{$invoice->code}",
                            'value' => (int) ($invoice->total * 100),
                            'amount' => 1,
                        ],
                    ],
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'tenant_id' => $invoice->tenant_id,
                    ],
                ]);

            if (!$response->successful()) {
                throw new \Exception("API Error: {$response->body()}");
            }

            $data = $response->json();
            $chargeId = $data['data']['id'] ?? null;

            // Gerar link de pagamento
            $paymentLink = $this->generatePaymentLink($chargeId, $token);

            return [
                'gateway' => 'efi',
                'status' => 'pending',
                'reference' => $chargeId,
                'payment_url' => $paymentLink,
                'message' => 'Charge created successfully',
            ];
        } catch (\Exception $e) {
            Log::error("Efi payment error: {$e->getMessage()}", [
                'invoice_id' => $invoice->id,
            ]);

            return [
                'gateway' => 'efi',
                'status' => 'failed',
                'reference' => null,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function processWebhook(array $payload, PaymentGatewayAccount $account): array
    {
        try {
            $event = $payload['event'] ?? null;
            $data = $payload['data'] ?? [];

            switch ($event) {
                case 'charge.confirmed':
                    return $this->handleChargeConfirmed($data);

                case 'charge.updated':
                    return $this->handleChargeUpdated($data);

                case 'charge.refunded':
                    return $this->handleChargeRefunded($data);

                default:
                    return [
                        'gateway' => 'efi',
                        'processed' => true,
                        'status' => 'ignored',
                        'message' => 'Event type not handled',
                    ];
            }
        } catch (\Exception $e) {
            Log::error("Efi webhook processing error: {$e->getMessage()}", [
                'payload' => $payload,
            ]);

            return [
                'gateway' => 'efi',
                'processed' => false,
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    private function getAccessToken(): ?string
    {
        try {
            $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
                ->post("{$this->API_URL}/oauth/token", [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Failed to get Efi access token: {$e->getMessage()}");
            return null;
        }
    }

    private function generatePaymentLink(int $chargeId, string $token): string
    {
        try {
            $response = Http::withToken($token)
                ->post("{$this->API_URL}/v1/charge/{$chargeId}/link", [
                    'expire_at' => now()->addDays(7)->timestamp,
                ]);

            if ($response->successful()) {
                return $response->json('data.url') ?? '';
            }

            return "https://gerencianet.com.br/charge/{$chargeId}";
        } catch (\Exception $e) {
            Log::warning("Failed to generate Efi payment link: {$e->getMessage()}");
            return "https://gerencianet.com.br/charge/{$chargeId}";
        }
    }

    private function handleChargeConfirmed(array $data): array
    {
        $chargeId = $data['id'] ?? null;
        $metadata = $data['metadata'] ?? [];
        $invoiceId = $metadata['invoice_id'] ?? null;

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => 'efi',
                    'payment_reference' => $chargeId,
                ]);
            }
        }

        return [
            'gateway' => 'efi',
            'processed' => true,
            'status' => 'confirmed',
            'message' => 'Charge confirmed',
        ];
    }

    private function handleChargeUpdated(array $data): array
    {
        $chargeId = $data['id'] ?? null;
        $status = $data['status'] ?? null;
        $metadata = $data['metadata'] ?? [];
        $invoiceId = $metadata['invoice_id'] ?? null;

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if ($invoice) {
                $invoiceStatus = match ($status) {
                    'open' => 'pending',
                    'paid' => 'paid',
                    'expired' => 'failed',
                    'cancelled' => 'cancelled',
                    default => 'pending',
                };

                $invoice->update([
                    'status' => $invoiceStatus,
                    'payment_reference' => $chargeId,
                ]);

                if ($invoiceStatus === 'paid') {
                    $invoice->update(['paid_at' => now()]);
                }
            }
        }

        return [
            'gateway' => 'efi',
            'processed' => true,
            'status' => $status,
            'message' => 'Charge updated',
        ];
    }

    private function handleChargeRefunded(array $data): array
    {
        $chargeId = $data['id'] ?? null;
        $metadata = $data['metadata'] ?? [];
        $invoiceId = $metadata['invoice_id'] ?? null;

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'refunded',
                    'payment_reference' => $chargeId,
                ]);
            }
        }

        return [
            'gateway' => 'efi',
            'processed' => true,
            'status' => 'refunded',
            'message' => 'Charge refunded',
        ];
    }
}
