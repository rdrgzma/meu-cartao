<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'nome' => 'Plano '.$this->faker->randomElement(['Básico', 'Plus', 'Premium']),
            'valor' => $this->faker->randomFloat(2, 29, 199),
            'descricao' => $this->faker->sentence,
            'ativo' => true,
        ];
    }
}
