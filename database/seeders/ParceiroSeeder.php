<?php

namespace Database\Seeders;

use App\Models\Carencia;
use App\Models\Plano;
use Illuminate\Database\Seeder;

class ParceiroSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();
        $especialidades = Especialidade::all();

        for ($i = 1; $i <= 10; $i++) {

            $parceiro = Parceiro::create([
                'tenant_id' => $tenant->id,
                'nome_fantasia' => "Clínica Saúde $i",
                'cidade' => 'Tramandaí',
                'estado' => 'RS',
                'status' => 'ativo'
            ]);

            $parceiro->especialidades()->attach(
                $especialidades->random(rand(1,3))->pluck('id')
            );
        }
    }
}  