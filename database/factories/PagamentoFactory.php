<?php

namespace Database\Factories;

use App\Models\Mensalidade;
use App\Models\Pagamento;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pagamento>
 */
class PagamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mensalidade_id' => Mensalidade::factory(),
            'tenant_id' => Tenant::factory(),
            'valor' => fake()->randomFloat(2, 50, 500),
            'data_pagamento' => now()->format('Y-m-d'),
        ];
    }
}
