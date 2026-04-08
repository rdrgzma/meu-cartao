<?php

use App\Models\Tenant;
use App\Models\Cliente;

it('filtra dados por tenant automaticamente', function () {

    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();

    app()->instance('tenant', $tenantA);

    Cliente::factory()->create(['tenant_id' => $tenantA->id]);
    Cliente::factory()->create(['tenant_id' => $tenantB->id]);

    $clientes = Cliente::all();

    expect($clientes)->toHaveCount(1);
});