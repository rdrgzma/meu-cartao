<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantResolver
{
    public function resolve(Request $request): ?Tenant
    {
        // 0. Simulação (Super Admin / Sistema)
        if (auth()->check() && auth()->user()->funcao === 'sistema' && session()->has('simulated_tenant_id')) {
            return Tenant::find(session('simulated_tenant_id'));
        }

        // 1. Header (API)
        if ($request->hasHeader('X-Tenant')) {
            return Tenant::where('slug', $request->header('X-Tenant'))->first();
        }

        // 2. Subdomínio
        $host = $request->getHost(); // empresa.sistema.com
        $parts = explode('.', $host);

        if (count($parts) > 2) {
            $slug = $parts[0];

            return Tenant::where('slug', $slug)->first();
        }

        // 3. Usuário autenticado
        if (auth()->check()) {
            return auth()->user()->tenant;
        }

        return null;
    }
}
