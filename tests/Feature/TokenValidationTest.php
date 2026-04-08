<?php

use App\Models\Cliente;
use App\Models\ClienteToken;
use App\Services\TokenValidationService;

it('valida token válido', function () {

    $cliente = Cliente::factory()->create();

    $token = ClienteToken::create([
        'cliente_id' => $cliente->id,
        'token' => 'abc123',
        'expires_at' => now()->addDay()
    ]);

    $service = new TokenValidationService();

    $resultado = $service->validar('abc123');

    expect($resultado)->not->toBeNull();
});