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
            // Se o usuário não estiver logado, permite passar para que o middleware 'auth' redirecione para login
            if (! auth()->check()) {
                return $next($request);
            }

            // Se for uma requisição API ou esperar JSON, retorna o erro em JSON
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'erro' => 'Tenant não identificado',
                ], 403);
            }

            // Para rotas web, se não identificou tenant e está logado,
            // talvez o usuário não tenha tenant (ex: erro de cadastro)
            // Aborta com erro amigável ou redireciona
            abort(403, 'Tenant não identificado. Verifique seu cadastro.');
        }

        if ($tenant) {
            // 🔥 Bloquear acesso se a unidade estiver inativa (exceto para Super Admin)
            if ($tenant->status === 'inativo' && (!auth()->check() || auth()->user()->funcao !== 'sistema')) {
                abort(403, 'Esta unidade está temporariamente inativa. Entre em contato com o suporte.');
            }

            app()->instance('tenant', $tenant);
        }

        return $next($request);
    }
}
