<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\TenantResolver;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $resolver = app(TenantResolver::class);

        $tenant = $resolver->resolve($request);

        if (!$tenant) {
            return response()->json([
                'erro' => 'Tenant não identificado'
            ], 403);
        }

        // 🔥 Armazena globalmente
        app()->instance('tenant', $tenant);

        return $next($request);
    }
}