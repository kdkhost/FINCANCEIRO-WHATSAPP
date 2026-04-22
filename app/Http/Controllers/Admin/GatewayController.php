<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayAccount;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GatewayController extends Controller
{
    public function index(): View
    {
        $accounts = PaymentGatewayAccount::query()->with('tenant')->latest()->get();
        $tenants = Tenant::query()->orderBy('name')->get();

        return view('admin.gateways.index', compact('accounts', 'tenants'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatedData($request);
        $account = PaymentGatewayAccount::query()->create($data)->load('tenant');

        return response()->json([
            'message' => 'Gateway salvo com sucesso.',
            'record_id' => $account->id,
            'row_html' => view('admin.gateways.partials.row', compact('account'))->render(),
        ]);
    }

    public function update(Request $request, PaymentGatewayAccount $gateway): JsonResponse
    {
        $gateway->update($this->validatedData($request));
        $gateway->refresh()->load('tenant');

        return response()->json([
            'message' => 'Gateway atualizado com sucesso.',
            'record_id' => $gateway->id,
            'row_html' => view('admin.gateways.partials.row', ['account' => $gateway])->render(),
        ]);
    }

    public function destroy(PaymentGatewayAccount $gateway): JsonResponse
    {
        $recordId = $gateway->id;
        $gateway->delete();

        return response()->json([
            'message' => 'Gateway removido com sucesso.',
            'record_id' => $recordId,
        ]);
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'gateway' => ['required', 'in:mercadopago,efi,stripe'],
            'label' => ['required', 'string', 'max:100'],
            'public_key' => ['nullable', 'string', 'max:255'],
            'secret_key' => ['nullable', 'string'],
            'webhook_secret' => ['nullable', 'string', 'max:255'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['settings'] = [
            'sandbox' => $request->boolean('sandbox'),
            'transparent_checkout' => $request->boolean('transparent_checkout'),
            'pix' => $request->boolean('pix'),
            'boleto' => $request->boolean('boleto'),
            'card' => $request->boolean('card'),
            'pass_gateway_fee' => $request->boolean('pass_gateway_fee'),
        ];

        return $data;
    }
}
