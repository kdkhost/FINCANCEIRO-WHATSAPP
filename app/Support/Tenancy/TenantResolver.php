<?php

namespace App\Support\Tenancy;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantResolver
{
    public function resolveFromRequest(Request $request): ?Tenant
    {
        $slug = $request->route('tenant');

        if (is_string($slug) && $slug !== '') {
            return Tenant::query()->where('slug', $slug)->first();
        }

        $host = $request->getHost();

        return Tenant::query()->where('primary_domain', $host)->first();
    }
}
