<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Carencia;
use Carbon\Carbon;

class ValidadorElegibilidadeService
{
    public function validar(Cliente $cliente, int $especialidadeId): array
    {
        // 1. Status do cliente
        if ($cliente->status !== 'ativo') {
            return $this->response('inadimplente', [], $cliente, $especialidadeId);
        }

        $plano = $cliente->plano;

        // 2. Verifica cobertura
        $cobertura = $plano->especialidades()
            ->wherePivot('especialidade_id', $especialidadeId)
            ->first();

        if (!$cobertura) {
            return $this->response('nao_coberto', [], $cliente, $especialidadeId);
        }

        // 3. Verifica carência
        $carencia = Carencia::where('plano_id', $plano->id)
            ->where('especialidade_id', $especialidadeId)
            ->first();

        if ($carencia && $carencia->dias > 0) {
            $dataLiberacao = Carbon::parse($cliente->data_adesao)
                ->addDays($carencia->dias);

            if (now()->lt($dataLiberacao)) {
                return $this->response('em_carencia', [
                    'liberado_em' => $dataLiberacao->toDateString()
                ], $cliente, $especialidadeId);
            }
        }

        $response = $this->response('liberado', [
            'tipo_cobertura' => $cobertura->pivot->tipo_cobertura
        ]);

        $this->recordAtendimento($cliente, $especialidadeId, 'liberado');

        return $response;
    }

    private function recordAtendimento(Cliente $cliente, int $especialidadeId, string $status): void
    {
        \App\Models\Atendimento::create([
            'cliente_id' => $cliente->id,
            'especialidade_id' => $especialidadeId,
            'parceiro_id' => auth()->user()->parceiro_id,
            'user_id' => auth()->id(),
            'status' => $status,
            'data_atendimento' => now(),
        ]);
    }

    private function response(string $status, array $extra = [], Cliente $cliente = null, int $especId = null): array
    {
        if ($cliente && $especId) {
            $this->recordAtendimento($cliente, $especId, $status);
        }

        return array_merge([
            'status' => $status
        ], $extra);
    }
}