<?php
use App\Models\Cliente;
use App\Services\ValidadorElegibilidadeService;

it('bloqueia cliente em carência', function () {

    $cliente = Cliente::factory()->create([
        'data_adesao' => now()
    ]);

    $service = app(ValidadorElegibilidadeService::class);

    $resultado = $service->validar($cliente, 1);

    expect($resultado['status'])
        ->toBeIn(['em_carencia','nao_coberto','inadimplente','liberado']);
});