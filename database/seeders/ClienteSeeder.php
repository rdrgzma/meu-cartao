<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Plano;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();
        $planos = Plano::all();

        for ($i = 1; $i <= 50; $i++) {

            Cliente::create([
                'tenant_id' => $tenant->id,
                'nome' => "Cliente $i",
                'cpf' => str_pad($i, 11, '0', STR_PAD_LEFT),
                'telefone' => '(51) 99999-0000',
                'data_adesao' => now()->subDays(rand(0,90)),
                'status' => rand(0,1) ? 'ativo' : 'inadimplente',
                'plano_id' => $planos->random()->id
            ]);
        }
    }
}
