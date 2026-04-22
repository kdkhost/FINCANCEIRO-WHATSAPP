<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminByIp
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = collect(config('financeiro.admin_allowed_ips', []))
            ->filter()
            ->values();

        if ($allowedIps->isNotEmpty() && ! $allowedIps->contains($request->ip())) {
            abort(403, 'IP nao autorizado para esta area.');
        }

        return $next($request);
    }
}
