<?php
use App\Models\Cliente;
use App\Services\VirtualCardService;

it('gera carteira com token válido', function () {

    $cliente = Cliente::factory()->create();

    $service = app(VirtualCardService::class);

    $carteira = $service->gerarCarteira($cliente);

    expect($carteira)
        ->toHaveKey('qr_code');

    expect($carteira['qr_code'])
        ->toContain('token=');
});