<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayAccount;
use App\Models\Tenant;
use App\Models\WebhookLog;
use App\Services\Billing\GatewayManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class WebhookController extends Controller
{
    public function __construct(
        protected GatewayManager $gatewayManager
    ) {
    }

    public function __invoke(Request $request, string $tenant, string $gateway): JsonResponse
    {
        try {
            $tenantModel = Tenant::query()
                ->where('slug', $tenant)
                ->orWhere('primary_domain', $tenant)
                ->firstOrFail();

            $account = PaymentGatewayAccount::query()
                ->where('tenant_id', $tenantModel->id)
                ->where('gateway', $gateway)
                ->where('is_active', true)
                ->firstOrFail();

            // Validar assinatura do webhook
            if (!$this->validateWebhookSignature($request, $gateway, $account)) {
                Log::warning("Invalid webhook signature", [
                    'tenant_id' => $tenantModel->id,
                    'gateway' => $gateway,
                    'ip' => $request->ip(),
                ]);

                return response()->json([
                    'error' => 'Invalid signature',
                    'received' => false,
                ], 401);
            }

            $result = $this->gatewayManager
                ->driver($gateway)
                ->processWebhook($request->all(), $account);

            if (Schema::hasTable('webhook_logs')) {
                WebhookLog::query()->create([
                    'tenant_id' => $account->tenant_id,
                    'type' => $gateway,
                    'status' => $result['processed'] ?? false ? 'success' : 'failed',
                    'request_data' => $request->all(),
                    'response_data' => $result,
                    'response_code' => 200,
                ]);
            }

            return response()->json([
                'received' => true,
                'tenant' => $tenantModel->slug,
                'gateway' => $gateway,
                'result' => $result,
            ]);
        } catch (\Exception $e) {
            Log::error("Webhook processing error", [
                'tenant' => $tenant,
                'gateway' => $gateway,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            if (Schema::hasTable('webhook_logs')) {
                WebhookLog::query()->create([
                    'tenant_id' => $request->input('tenant_id'),
                    'type' => $gateway,
                    'status' => 'error',
                    'request_data' => $request->all(),
                    'response_data' => ['error' => $e->getMessage()],
                    'response_code' => 500,
                ]);
            }

            return response()->json([
                'error' => 'Webhook processing failed',
                'received' => false,
            ], 500);
        }
    }

    /**
     * Valida a assinatura do webhook
     *
     * @param Request $request
     * @param string $gateway
     * @param PaymentGatewayAccount $account
     * @return bool
     */
    private function validateWebhookSignature(Request $request, string $gateway, PaymentGatewayAccount $account): bool
    {
        // Se não houver header de assinatura, aceitar (para testes)
        if (!$request->hasHeader('X-Webhook-Signature')) {
            return config('app.debug', false);
        }

        $signature = $request->header('X-Webhook-Signature');
        $payload = $request->getContent();

        switch ($gateway) {
            case 'stripe':
                return $this->validateStripeSignature($signature, $payload, $account);

            case 'mercadopago':
                return $this->validateMercadoPagoSignature($signature, $payload, $account);

            case 'efi':
                return $this->validateEfiSignature($signature, $payload, $account);

            default:
                return true;
        }
    }

    /**
     * Valida assinatura Stripe
     */
    private function validateStripeSignature(string $signature, string $payload, PaymentGatewayAccount $account): bool
    {
        $secret = config('services.stripe.webhook_secret');

        if (!$secret) {
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($signature, $computedSignature);
    }

    /**
     * Valida assinatura MercadoPago
     */
    private function validateMercadoPagoSignature(string $signature, string $payload, PaymentGatewayAccount $account): bool
    {
        $secret = config('services.mercadopago.webhook_secret');

        if (!$secret) {
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($signature, $computedSignature);
    }

    /**
     * Valida assinatura Efi
     */
    private function validateEfiSignature(string $signature, string $payload, PaymentGatewayAccount $account): bool
    {
        $secret = config('services.efi.webhook_secret');

        if (!$secret) {
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($signature, $computedSignature);
    }
}
