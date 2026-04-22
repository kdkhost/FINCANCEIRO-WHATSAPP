<?php

namespace App\Http\Controllers\Api\V1\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tenant = app('currentTenant');

        $customers = Customer::query()
            ->where('tenant_id', $tenant?->id)
            ->latest()
            ->paginate(15);

        return response()->json($customers);
    }
}
