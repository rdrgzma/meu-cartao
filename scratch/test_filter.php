<?php
use App\Models\Cliente;
use App\Models\Tenant;

// Simulate a system user
$user = App\Models\User::where('funcao', 'sistema')->first();
auth()->login($user);

// Simulate selecting a tenant
session(['simulated_tenant_id' => 1]); // Adjust ID if needed

$resolver = app(App\Services\TenantResolver::class);
$tenant = $resolver->resolve(request());

echo "Resolved Tenant: " . ($tenant ? $tenant->nome : 'None') . "\n";

if ($tenant) {
    app()->instance('tenant', $tenant);
}

if (app()->bound('tenant')) {
    echo "Tenant is bound: " . app('tenant')->nome . "\n";
}

$query = Cliente::query()->toSql();
echo "Query SQL: " . $query . "\n";

$bindings = Cliente::query()->getBindings();
echo "Bindings: " . json_encode($bindings) . "\n";
