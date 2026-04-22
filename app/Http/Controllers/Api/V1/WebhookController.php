<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayAccount;
use App\Services\Billing\GatewayManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __construct(
        protected GatewayManager $gatewayManager
    ) {
    }

    public function __invoke(Request $request, string $tenant, string $gateway): JsonResponse
    {
        $account = PaymentGatewayAccount::query()
            ->where('tenant_id', optional(app('currentTenant'))->id)
            ->where('gateway', $gateway)
            ->where('is_active', true)
            ->firstOrFail();

        $result = $this->gatewayManager
            ->driver($gateway)
            ->processWebhook($request->all(), $account);

        return response()->json([
            'received' => true,
            'tenant' => $tenant,
            'gateway' => $gateway,
            'result' => $result,
        ]);
    }
}
