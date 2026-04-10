<?php

namespace App\Http\Middleware;

use App\Services\TenantResolver;
use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 🔥 Permitir login, home e rotas de sistema sem Tenant identificado
        if ($request->is('/', 'login', 'logout', 'up', 'register', 'home')) {
            return $next($request);
        }

        $resolver = app(TenantResolver::class);
        $tenant = $resolver->resolve($request);

        // 🔥 Permitir que Super Admin (sistema) acesse sem Tenant (vê tudo)
        // Mas se houver um tenant resolvido (Ex: simulação ou subdomain), vincula ele
        if (auth()->check() && auth()->user()->funcao === 'sistema') {
            if ($tenant) {
                app()->instance('tenant', $tenant);
            }

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
