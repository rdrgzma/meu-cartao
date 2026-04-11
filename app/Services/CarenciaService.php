<?php
namespace App\Services;

use App\Models\Cliente;
use App\Models\Carencia;
use Carbon\Carbon;

class CarenciaService
{
    public function calcularDataLiberacao(Cliente $cliente, int $especialidadeId): ?Carbon
    {
        $carencia = Carencia::where('plano_id', $cliente->plano_id)
            ->where('especialidade_id', $especialidadeId)
            ->first();

        if (!$carencia || $carencia->dias == 0) {
            return null;
        }

        return Carbon::parse($cliente->data_adesao)
            ->addDays($carencia->dias);
    }

    public function estaEmCarencia(Cliente $cliente, int $especialidadeId): bool
    {
        $data = $this->calcularDataLiberacao($cliente, $especialidadeId);

        return $data && now()->lt($data);
    }
}