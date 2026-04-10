<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Parceiro;
use App\Models\Plano;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Super Admin (Acesso total ao sistema - Vê tudo)
        User::updateOrCreate(['email' => 'sistema@cartaomaisaude.com.br'], [
            'name' => 'Suporte Sistema',
            'password' => $password,
            'tipo' => 'admin',
            'funcao' => 'sistema',
            'status' => 'ativo',
            'tenant_id' => null,
        ]);

        $tenantsInfo = [
            'matriz' => 'Matriz Cartão Mais Saúde',
            'unidade-centro' => 'CMS Unidade Centro',
            'unidade-sul' => 'CMS Unidade Sul',
            'unidade-norte' => 'CMS Unidade Norte',
            'unidade-oeste' => 'CMS Unidade Oeste',
        ];

        foreach ($tenantsInfo as $slug => $nome) {
            $tenant = Tenant::updateOrCreate(['slug' => $slug], [
                'nome' => $nome,
                'documento' => fake()->numerify('##.###.###/0001-##'),
                'cidade' => fake()->city,
                'estado' => fake()->stateAbbr,
            ]);

            // Plano padrão para o tenant
            $planoPadrao = Plano::factory()->create(['tenant_id' => $tenant->id, 'nome' => 'Plano Controle '.$nome]);

            // 2. Admin de Unidade (Gestor de uma unidade específica)
            User::updateOrCreate(['email' => "admin@{$slug}.com.br"], [
                'name' => "Gestor {$nome}",
                'tenant_id' => $tenant->id,
                'password' => $password,
                'tipo' => 'admin',
                'funcao' => 'admin',
                'status' => 'ativo',
            ]);

            // 3. Parceiro (Operador)
            $parceiro = Parceiro::factory()->create([
                'tenant_id' => $tenant->id,
                'nome_fantasia' => 'Clínica '.fake()->firstName.' - '.$nome,
            ]);

            User::updateOrCreate(['email' => "parceiro@{$slug}.com.br"], [
                'name' => 'Atendente '.$parceiro->nome_fantasia,
                'tenant_id' => $tenant->id,
                'parceiro_id' => $parceiro->id,
                'password' => $password,
                'tipo' => 'usuario',
                'funcao' => 'parceiro',
                'status' => 'ativo',
            ]);

            // 4. Cliente (Assinante)
            $cliente = Cliente::factory()->create([
                'tenant_id' => $tenant->id,
                'plano_id' => $planoPadrao->id,
                'nome' => 'Cliente '.fake()->name.' ('.$nome.')',
            ]);

            User::updateOrCreate(['email' => "cliente@{$slug}.com.br"], [
                'name' => $cliente->nome,
                'tenant_id' => $tenant->id,
                'cliente_id' => $cliente->id,
                'password' => $password,
                'tipo' => 'usuario',
                'funcao' => 'cliente',
                'status' => 'ativo',
            ]);

            // Dados Extras para testar a segregação
            Plano::factory(2)->create(['tenant_id' => $tenant->id]);
            Parceiro::factory(2)->create(['tenant_id' => $tenant->id]);
            Cliente::factory(5)->create(['tenant_id' => $tenant->id, 'plano_id' => $planoPadrao->id]);
        }
    }
}
