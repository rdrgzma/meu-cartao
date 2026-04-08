<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'nome' => 'Cartão Mais Saúde',
            'slug' => 'cartao-mais-saude'
        ]);
    }
}
