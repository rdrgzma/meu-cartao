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
                'telefone'=> random_int(1000000000, 9999999999),
                'documento'=>random_int(10000000000, 99999999999),
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
