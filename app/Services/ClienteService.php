<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteService
{
    protected CnsService $cnsService;

    public function __construct(CnsService $cnsService)
    {
        $this->cnsService = $cnsService;
    }
    public function criar(array $data): Cliente
    {
        return DB::transaction(function () use ($data) {

            if (!empty($data['cns']) && !$this->cnsService->validar($data['cns'])) {
                throw new \Exception('CNS inválido');
            }
            $cliente = Cliente::create($data);

            $cliente->historicoPlanos()->create([
                'plano_id' => $data['plano_id'],
                'inicio' => now()
            ]);

            return $cliente;
        });
    }

    public function trocarPlano(Cliente $cliente, int $novoPlanoId): void
    {
        DB::transaction(function () use ($cliente, $novoPlanoId) {

            // fecha plano atual
            $cliente->historicoPlanos()
                ->whereNull('fim')
                ->update(['fim' => now()]);

            // novo plano
            $cliente->historicoPlanos()->create([
                'plano_id' => $novoPlanoId,
                'inicio' => now()
            ]);

            $cliente->update([
                'plano_id' => $novoPlanoId,
                'data_adesao' => now() // reinicia carência
            ]);
        });
    }
}
