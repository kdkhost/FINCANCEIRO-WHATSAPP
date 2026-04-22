<?php

namespace App\Http\Controllers\Api\V1\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tenant = Tenant::query()
            ->where('slug', (string) $request->route('tenant'))
            ->orWhere('primary_domain', (string) $request->route('tenant'))
            ->firstOrFail();

        $customers = Customer::query()
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->paginate(15);

        return response()->json($customers);
    }
}
