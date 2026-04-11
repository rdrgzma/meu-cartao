<?php

use App\Models\Cliente;
use App\Models\Plano;
use App\Models\Tenant;
use App\Services\ClienteService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it generates a pending monthly payment when creating a client', function () {
    $tenant = Tenant::factory()->create();
    $plano = Plano::factory()->create(['valor' => 150.00, 'tenant_id' => $tenant->id]);

    $service = app(ClienteService::class);

    $data = [
        'nome' => 'João Silva',
        'cpf' => '12345678901',
        'email' => 'joao@example.com',
        'telefone' => '51999999999',
        'data_adesao' => now()->format('Y-m-d'),
        'status' => 'ativo',
        'plano_id' => $plano->id,
        'tenant_id' => $tenant->id,
    ];

    $cliente = $service->criar($data);

    expect($cliente->mensalidades)->toHaveCount(1);
    expect($cliente->mensalidades->first()->valor)->toEqual(150.00);
    expect($cliente->mensalidades->first()->status)->toBe('pendente');
});

test('it generates a new pending monthly payment when changing client plan', function () {
    $tenant = Tenant::factory()->create();
    $planoAntigo = Plano::factory()->create(['valor' => 100.00, 'tenant_id' => $tenant->id]);
    $planoNovo = Plano::factory()->create(['valor' => 200.00, 'tenant_id' => $tenant->id]);

    $cliente = Cliente::factory()->create([
        'plano_id' => $planoAntigo->id,
        'tenant_id' => $tenant->id,
    ]);

    // Simulate that the client already has 1 monthly payment (optional but realistic)
    $cliente->mensalidades()->create([
        'tenant_id' => $tenant->id,
        'valor' => 100.00,
        'vencimento' => now()->subMonth(),
        'status' => 'pago',
    ]);

    $service = app(ClienteService::class);
    $service->trocarPlano($cliente, $planoNovo->id);

    // Should have 2 now
    $cliente->refresh();
    expect($cliente->mensalidades)->toHaveCount(2);

    $novaMensalidade = $cliente->mensalidades()->latest('id')->first();
    expect($novaMensalidade->valor)->toEqual(200.00);
    expect($novaMensalidade->status)->toBe('pendente');
});
