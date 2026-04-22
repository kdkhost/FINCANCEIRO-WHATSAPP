<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayAccount;
use App\Models\Tenant;
use App\Models\WebhookLog;
use App\Services\Billing\GatewayManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class WebhookController extends Controller
{
    public function __construct(
        protected GatewayManager $gatewayManager
    ) {
    }

    public function __invoke(Request $request, string $tenant, string $gateway): JsonResponse
    {
        $tenantModel = Tenant::query()
            ->where('slug', $tenant)
            ->orWhere('primary_domain', $tenant)
            ->firstOrFail();

        $account = PaymentGatewayAccount::query()
            ->where('tenant_id', $tenantModel->id)
            ->where('gateway', $gateway)
            ->where('is_active', true)
            ->firstOrFail();

        $result = $this->gatewayManager
            ->driver($gateway)
            ->processWebhook($request->all(), $account);

        if (Schema::hasTable('webhook_logs')) {
            WebhookLog::query()->create([
                'tenant_id' => $account->tenant_id,
                'gateway' => $gateway,
                'event_type' => (string) ($request->input('type') ?? $request->input('action') ?? 'webhook'),
                'payload' => $request->all(),
                'response_body' => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'status_code' => 200,
                'processed_at' => now(),
            ]);
        }

        return response()->json([
            'received' => true,
            'tenant' => $tenantModel->slug,
            'gateway' => $gateway,
            'result' => $result,
        ]);
    }
}
