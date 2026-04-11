<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Mensalidade;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mensalidade>
 */
class MensalidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'tenant_id' => Tenant::factory(),
            'valor' => fake()->randomFloat(2, 50, 500),
            'vencimento' => now()->addDays(10)->format('Y-m-d'),
            'status' => 'pendente',
        ];
    }
}
