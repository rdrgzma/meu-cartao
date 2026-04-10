<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use App\Models\Parceiro;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ParceiroSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();
        if (! $tenant) {
            return;
        }

        $especialidades = Especialidade::all();
        if ($especialidades->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            $parceiro = Parceiro::create([
                'tenant_id' => $tenant->id,
                'nome_fantasia' => "Clínica Saúde $i",
                'cidade' => 'Tramandaí',
                'estado' => 'RS',
                'status' => 'ativo',
            ]);

            $parceiro->especialidades()->attach(
                $especialidades->random(min(3, $especialidades->count()))->pluck('id')
            );
        }
    }
}
