<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::query()->with('tenant')->latest()->get();
        $tenants = Tenant::query()->orderBy('name')->get();

        return view('admin.customers.index', compact('customers', 'tenants'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:25'],
            'document_type' => ['nullable', 'in:cpf,cnpj'],
            'document_number' => ['nullable', 'string', 'max:30'],
            'zipcode' => ['nullable', 'string', 'max:10'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'address_number' => ['nullable', 'string', 'max:20'],
            'address_extra' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'notes' => ['nullable', 'string'],
        ]);

        $customer = Customer::query()->create($data)->load('tenant');

        return response()->json([
            'message' => 'Cliente criado com sucesso.',
            'record_id' => $customer->id,
            'row_html' => view('admin.customers.partials.row', compact('customer'))->render(),
        ]);
    }

    public function update(Request $request, Customer $customer): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:25'],
            'document_type' => ['nullable', 'in:cpf,cnpj'],
            'document_number' => ['nullable', 'string', 'max:30'],
            'zipcode' => ['nullable', 'string', 'max:10'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'address_number' => ['nullable', 'string', 'max:20'],
            'address_extra' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'notes' => ['nullable', 'string'],
        ]);

        $customer->update($data);
        $customer->refresh()->load('tenant');

        return response()->json([
            'message' => 'Cliente atualizado com sucesso.',
            'record_id' => $customer->id,
            'row_html' => view('admin.customers.partials.row', compact('customer'))->render(),
        ]);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $recordId = $customer->id;
        $customer->delete();

        return response()->json([
            'message' => 'Cliente removido com sucesso.',
            'record_id' => $recordId,
        ]);
    }
}
