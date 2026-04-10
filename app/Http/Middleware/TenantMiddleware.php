<?php

namespace App\Http\Middleware;

use App\Services\TenantResolver;
use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 🔥 Permitir login e rotas de sistema sem Tenant identificado
        if ($request->is('login', 'logout', 'up', 'register')) {
            return $next($request);
        }

        $resolver = app(TenantResolver::class);
        $tenant = $resolver->resolve($request);

        // 🔥 Permitir que Super Admin (sistema) acesse sem Tenant (vê tudo)
        if (auth()->check() && auth()->user()->funcao === 'sistema') {
            return $next($request);
        }

        if (! $tenant) {
            return response()->json([
                'erro' => 'Tenant não identificado',
            ], 403);
        }

        // 🔥 Armazena globalmente
        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
