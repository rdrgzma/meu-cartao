<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Plano;
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
            ->with(['plano', 'tenant'])
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

            $this->gerarMensalidadePendente($cliente, (int) $data['plano_id']);

            LogService::registrar(
                'Clientes',
                'Novo Cliente',
                "Cliente {$cliente->nome} cadastrado com o plano {$cliente->plano->nome}.",
                ['cliente_id' => $cliente->id]
            );

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

            $sucesso = $cliente->update($data);

            if ($sucesso) {
                LogService::registrar(
                    'Clientes',
                    'Atualização de Cadastro',
                    "Dados do cliente {$cliente->nome} foram atualizados.",
                    ['cliente_id' => $cliente->id]
                );
            }

            return $sucesso;
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

            $this->gerarMensalidadePendente($cliente, $novoPlanoId);

            LogService::registrar(
                'Clientes',
                'Troca de Plano',
                "Plano do cliente {$cliente->nome} alterado para {$cliente->plano->nome}.",
                ['cliente_id' => $cliente->id, 'novo_plano_id' => $novoPlanoId]
            );
        });
    }

    /**
     * Generate a pending monthly payment for the client.
     */
    private function gerarMensalidadePendente(Cliente $cliente, int $planoId): void
    {
        $plano = Plano::find($planoId);

        if ($plano) {
            $cliente->mensalidades()->create([
                'tenant_id' => $cliente->tenant_id,
                'valor' => $plano->valor,
                'vencimento' => now(),
                'status' => 'pendente',
            ]);
        }
    }

    /**
     * Delete a client.
     */
    public function delete(Cliente $cliente): bool
    {
        $nome = $cliente->nome;
        $id = $cliente->id;
        $sucesso = $cliente->delete();

        if ($sucesso) {
            LogService::registrar(
                'Clientes',
                'Exclusão de Cliente',
                "Cliente {$nome} (ID: {$id}) foi removido do sistema.",
                ['cliente_id' => $id]
            );
        }

        return $sucesso;
    }
}
