<?php

use App\Livewire\Financeiro\BaixaModal;
use App\Models\Cliente;
use App\Models\Mensalidade;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('it can register a payment for a monthly bill', function () {
    $tenant = Tenant::factory()->create();
    $cliente = Cliente::factory()->create(['tenant_id' => $tenant->id]);
    $mensalidade = Mensalidade::factory()->create([
        'cliente_id' => $cliente->id,
        'tenant_id' => $tenant->id,
        'valor' => 100.00,
        'status' => 'pendente',
    ]);

    Livewire::test(BaixaModal::class)
        ->call('setMensalidade', $mensalidade->id)
        ->set('valor_pago', 100.00)
        ->set('data_pagamento', now()->format('Y-m-d'))
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('pagamentoRegistrado');

    $mensalidade->refresh();
    expect($mensalidade->status)->toBe('pago');
    expect($mensalidade->pagamentos)->toHaveCount(1);
    expect((float) $mensalidade->pagamentos->first()->valor)->toEqual(100.00);
});

test('it does not crash if save is called without a monthly bill', function () {
    Livewire::test(BaixaModal::class)
        ->call('save')
        ->assertHasNoErrors(); // Should just return early without error
});
