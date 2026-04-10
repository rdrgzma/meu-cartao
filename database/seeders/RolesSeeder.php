<?php

namespace Database\Seeders;

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
        // 1. Criar Tenant Principal
        $tenantMatriz = Tenant::firstOrCreate(['slug' => 'matriz'], [
            'nome' => 'Matriz Cartão Mais Saúde',
            'documento' => '00.000.000/0001-00',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
        ]);

        $tenantUnidade = Tenant::firstOrCreate(['slug' => 'unidade-teste'], [
            'nome' => 'CMS Unidade Centro',
            'documento' => '11.111.111/0001-11',
            'cidade' => 'Curitiba',
            'estado' => 'PR',
        ]);

        $password = Hash::make('password');

        // 2. Super Admin (Acesso total ao sistema)
        User::firstOrCreate(['email' => 'sistema@cartaomaisaude.com.br'], [
            'name' => 'Suporte Sistema',
            'password' => $password,
            'tipo' => 'admin',
            'funcao' => 'sistema',
            'status' => 'ativo',
        ]);

        // 3. Admin de Unidade (Gestor de uma unidade específica)
        User::firstOrCreate(['email' => 'admin@matriz.com.br'], [
            'name' => 'Administrador Matriz',
            'tenant_id' => $tenantMatriz->id,
            'password' => $password,
            'tipo' => 'admin',
            'funcao' => 'admin',
            'status' => 'ativo',
        ]);

        // 4. Operador de Parceiro (Acesso ao painel de validação)
        User::firstOrCreate(['email' => 'clinica@parceiro.com.br'], [
            'name' => 'Clínica Vida - Parceiro',
            'tenant_id' => $tenantMatriz->id,
            'password' => $password,
            'tipo' => 'usuario',
            'funcao' => 'parceiro',
            'status' => 'ativo',
        ]);

        // 5. Cliente (Acesso à carteira virtual)
        User::firstOrCreate(['email' => 'cliente@teste.com.br'], [
            'name' => 'João Silva - Cliente',
            'tenant_id' => $tenantMatriz->id,
            'password' => $password,
            'tipo' => 'usuario',
            'funcao' => 'cliente',
            'status' => 'ativo',
        ]);
    }
}
