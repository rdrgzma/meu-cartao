<?php
namespace App\Services;

use App\Models\Plano;

class PlanoService
{
    public function vincularEspecialidades(Plano $plano, array $dados): void
    {
        // $dados = [especialidade_id => ['tipo_cobertura' => 'total']]
        $plano->especialidades()->sync($dados);
    }

    public function definirCarencias(Plano $plano, array $carencias): void
    {
        foreach ($carencias as $especialidadeId => $dias) {
            $plano->carencias()->updateOrCreate(
                ['especialidade_id' => $especialidadeId],
                ['dias' => $dias]
            );
        }
    }
}