<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'nome' => $this->faker->name,
            'cpf' => $this->faker->unique()->numerify('###########'),
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'data_adesao' => now()->subDays(rand(0, 120)),
            'status' => $this->faker->randomElement(['ativo','inadimplente']),
            'plano_id' => Plano::factory(),
        ];
    }
}
