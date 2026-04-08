<?php

namespace Database\Seeders;

use App\Models\Carencia;
use App\Models\Plano;
use Illuminate\Database\Seeder;

class CarenciaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Plano::all() as $plano) {
            foreach ($plano->especialidades as $esp) {

                $dias = match($esp->nome) {
                    'Odontologia' => 30,
                    'Fisioterapia' => 60,
                    default => 0
                };

                Carencia::create([
                    'plano_id' => $plano->id,
                    'especialidade_id' => $esp->id,
                    'dias' => $dias
                ]);
            }
        }
    }
}
