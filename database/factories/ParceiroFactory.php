<?php

namespace Database\Factories;

use App\Models\Parceiro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParceiroFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'nome_fantasia' => $this->faker->company,
            'razao_social' => $this->faker->company,
            'documento' => $this->faker->numerify('##############'),
            'telefone' => $this->faker->phoneNumber,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'status' => 'ativo',
        ];
    }
}
