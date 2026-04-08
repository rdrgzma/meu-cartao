<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use Illuminate\Database\Seeder;
class EspecialidadeSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $especialidades = [
            'Clínico Geral',
            'Odontologia',
            'Pediatria',
            'Ginecologia',
            'Cardiologia',
            'Ortopedia',
            'Fisioterapia',
            'Psicologia'
        ];

        foreach ($especialidades as $nome) {
            Especialidade::create([
                'tenant_id' => $tenant->id,
                'nome' => $nome
            ]);
        }
    }
}
