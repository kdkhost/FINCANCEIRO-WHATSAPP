<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSaasAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->is_saas_admin) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Acesso restrito ao dono do SaaS.',
                ], 403);
            }

            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
