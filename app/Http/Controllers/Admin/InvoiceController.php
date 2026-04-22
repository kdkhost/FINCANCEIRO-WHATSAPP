<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::query()->with(['tenant', 'customer'])->latest()->get();
        $tenants = Tenant::query()->orderBy('name')->get();
        $customers = Customer::query()->with('tenant')->orderBy('name')->get();

        return view('admin.invoices.index', compact('invoices', 'tenants', 'customers'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'code' => ['nullable', 'string', 'max:40'],
            'status' => ['required', 'in:draft,pending,paid,overdue,cancelled'],
            'description' => ['nullable', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
            'gateway' => ['nullable', 'in:mercadopago,efi,stripe'],
            'payment_url' => ['nullable', 'url'],
            'external_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $data['code'] = $data['code'] ?: 'FAT-'.Str::upper(Str::random(8));

        $invoice = Invoice::query()->create($data)->load(['tenant', 'customer']);

        return response()->json([
            'message' => 'Cobranca criada com sucesso.',
            'record_id' => $invoice->id,
            'row_html' => view('admin.invoices.partials.row', compact('invoice'))->render(),
        ]);
    }

    public function update(Request $request, Invoice $invoice): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'code' => ['required', 'string', 'max:40', 'unique:invoices,code,'.$invoice->id],
            'status' => ['required', 'in:draft,pending,paid,overdue,cancelled'],
            'description' => ['nullable', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
            'gateway' => ['nullable', 'in:mercadopago,efi,stripe'],
            'payment_url' => ['nullable', 'url'],
            'external_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $invoice->update($data);
        $invoice->refresh()->load(['tenant', 'customer']);

        return response()->json([
            'message' => 'Cobranca atualizada com sucesso.',
            'record_id' => $invoice->id,
            'row_html' => view('admin.invoices.partials.row', compact('invoice'))->render(),
        ]);
    }

    public function destroy(Invoice $invoice): JsonResponse
    {
        $recordId = $invoice->id;
        $invoice->delete();

        return response()->json([
            'message' => 'Cobranca removida com sucesso.',
            'record_id' => $recordId,
        ]);
    }
}
