<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $basico = Plano::create([
            'tenant_id' => $tenant->id,
            'nome' => 'Plano Básico',
            'valor' => 39.90
        ]);

        $premium = Plano::create([
            'tenant_id' => $tenant->id,
            'nome' => 'Plano Premium',
            'valor' => 79.90
        ]);

        $especialidades = Especialidade::all();

        foreach ($especialidades as $esp) {

            // Básico cobre poucas
            if (in_array($esp->nome, ['Clínico Geral','Odontologia'])) {
                $basico->especialidades()->attach($esp->id);
            }

            // Premium cobre todas
            $premium->especialidades()->attach($esp->id);
        }
    }
}