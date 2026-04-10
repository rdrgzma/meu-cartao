<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            RolesSeeder::class,
            EspecialidadeSeeder::class,
            PlanoSeeder::class,
            ParceiroSeeder::class,
            ClienteSeeder::class,   
            CarenciaSeeder::class,
        ]);
    }
}
