<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ClienteService
{
    protected CnsService $cnsService;

    public function __construct(CnsService $cnsService)
    {
        $this->cnsService = $cnsService;
    }

    /**
     * Get paginated clients with advanced filters.
     */
    public function paginate(int $perPage = 10, ?string $search = null, ?string $status = null, ?string $dataInicio = null, ?string $dataFim = null): LengthAwarePaginator
    {
        return Cliente::query()
            ->when($search, function ($q) use ($search) {
                $q->where(fn ($query) => $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($dataInicio, fn ($q) => $q->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('created_at', '<=', $dataFim))
            ->with('plano')
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Create a new client.
     */
    public function criar(array $data): Cliente
    {
        return DB::transaction(function () use ($data) {
            if (! empty($data['cns']) && ! $this->cnsService->validar($data['cns'])) {
                throw new \Exception('CNS inválido');
            }

            $cliente = Cliente::create($data);

            $cliente->historicoPlanos()->create([
                'plano_id' => $data['plano_id'],
                'inicio' => now(),
            ]);

            return $cliente;
        });
    }

    /**
     * Update an existing client.
     */
    public function update(Cliente $cliente, array $data): bool
    {
        return DB::transaction(function () use ($cliente, $data) {
            if (! empty($data['cns']) && ! $this->cnsService->validar($data['cns'])) {
                throw new \Exception('CNS inválido');
            }

            if (isset($data['plano_id']) && $data['plano_id'] != $cliente->plano_id) {
                $this->trocarPlano($cliente, (int) $data['plano_id']);
                unset($data['plano_id']);
            }

            return $cliente->update($data);
        });
    }

    /**
     * Switch client plan.
     */
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
                'inicio' => now(),
            ]);

            $cliente->update([
                'plano_id' => $novoPlanoId,
                // data_adesao = now() // Decisão: reinicia carência no PRD diz que varia por especialidade e base é adesão
            ]);
        });
    }

    /**
     * Delete a client.
     */
    public function delete(Cliente $cliente): bool
    {
        return $cliente->delete();
    }
}
