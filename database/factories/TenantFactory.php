<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    public function definition(): array
    {
        $nome = $this->faker->unique()->company;

        return [
            'nome' => $nome,
            'slug' => Str::slug($nome),
            'documento' => $this->faker->numerify('##.###.###/0001-##'),
            'telefone' => $this->faker->phoneNumber,
            'endereco' => $this->faker->streetAddress,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
        ];
    }
}
