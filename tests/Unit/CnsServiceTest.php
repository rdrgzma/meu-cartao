<?php

use App\Services\CnsService;

it('valida CNS válido', function () {

    $service = new CnsService();

    $cnsValido = '898001160444747'; // exemplo válido

    expect($service->validar($cnsValido))->toBeTrue();
});

it('rejeita CNS inválido', function () {

    $service = new CnsService();

    expect($service->validar('123'))->toBeFalse();
});