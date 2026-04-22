<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $startTime;

        // Log apenas para usuários autenticados
        if ($request->user()) {
            Log::channel('activity')->info('User Activity', [
                'user_id' => $request->user()->id,
                'user_email' => $request->user()->email,
                'tenant_id' => $request->user()->tenant_id,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status_code' => $response->getStatusCode(),
                'duration' => round($duration * 1000, 2) . 'ms',
                'timestamp' => now()->toIso8601String(),
            ]);
        }

        return $response;
    }
}
