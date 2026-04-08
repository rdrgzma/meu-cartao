<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    public function definition(): array
    {
        $nome = $this->faker->company;

        return [
            'nome' => $nome,
            'slug' => Str::slug($nome) . '-' . Str::random(5),
        ];
    }
}
