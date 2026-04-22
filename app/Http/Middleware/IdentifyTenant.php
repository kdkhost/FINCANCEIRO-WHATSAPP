<?php

namespace App\Http\Middleware;

use App\Support\Tenancy\TenantResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function __construct(
        protected TenantResolver $tenantResolver
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $this->tenantResolver->resolveFromRequest($request);

        if ($tenant) {
            app()->instance('currentTenant', $tenant);
        }

        return $next($request);
    }
}
