<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::query()->latest()->get();

        return view('admin.tenants.index', compact('tenants'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150', 'unique:tenants,slug'],
            'primary_domain' => ['nullable', 'string', 'max:255', 'unique:tenants,primary_domain'],
            'status' => ['required', 'in:trial,active,suspended,cancelled'],
            'trial_ends_at' => ['nullable', 'date'],
            'subscription_ends_at' => ['nullable', 'date'],
        ]);

        $data['uuid'] = (string) Str::uuid();
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        $tenant = Tenant::query()->create($data);

        return response()->json([
            'message' => 'Tenant criado com sucesso.',
            'record_id' => $tenant->id,
            'row_html' => view('admin.tenants.partials.row', compact('tenant'))->render(),
        ]);
    }

    public function update(Request $request, Tenant $tenant): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150', 'unique:tenants,slug,'.$tenant->id],
            'primary_domain' => ['nullable', 'string', 'max:255', 'unique:tenants,primary_domain,'.$tenant->id],
            'status' => ['required', 'in:trial,active,suspended,cancelled'],
            'trial_ends_at' => ['nullable', 'date'],
            'subscription_ends_at' => ['nullable', 'date'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        $tenant->update($data);
        $tenant->refresh();

        return response()->json([
            'message' => 'Tenant atualizado com sucesso.',
            'record_id' => $tenant->id,
            'row_html' => view('admin.tenants.partials.row', compact('tenant'))->render(),
        ]);
    }

    public function destroy(Tenant $tenant): JsonResponse
    {
        $recordId = $tenant->id;
        $tenant->delete();

        return response()->json([
            'message' => 'Tenant removido com sucesso.',
            'record_id' => $recordId,
        ]);
    }
}
