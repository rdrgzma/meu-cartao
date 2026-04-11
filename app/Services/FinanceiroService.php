<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Mensalidade;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class FinanceiroService
{
    /**
     * Get paginated monthly payments with advanced filters.
     */
    public function paginate(int $perPage = 10, ?string $search = null, ?string $status = null, ?string $dataInicio = null, ?string $dataFim = null): LengthAwarePaginator
    {
        return Mensalidade::query()
            ->with(['cliente', 'cliente.plano', 'cliente.tenant'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('cliente', fn ($q) => $q->where('nome', 'like', "%{$search}%"));
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($dataInicio, fn ($q) => $q->whereDate('vencimento', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('vencimento', '<=', $dataFim))
            ->orderBy('vencimento', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get monthly payments for a specific client.
     */
    public function getClientMensalidades(int $clienteId)
    {
        return Mensalidade::where('cliente_id', $clienteId)
            ->orderBy('vencimento', 'desc')
            ->get();
    }

    /**
     * Generate a new monthly payment for a client.
     */
    public function gerarMensalidade(Cliente $cliente, ?Carbon $vencimento = null): Mensalidade
    {

        $mensalidade = Mensalidade::create([
            'cliente_id' => $cliente->id,
            'valor' => $cliente->plano->valor,
            'vencimento' => $vencimento ?? now()->addMonth(),
            'status' => 'pendente',
        ]);
        if ($mensalidade) {
            LogService::registrar(
                'Financeiro',
                'Geração de Mensalidade',
                "Mensalidade gerada para {$cliente->nome} no valor de R$ ".number_format($cliente->plano->valor, 2, ',', '.'),
                ['cliente_id' => $cliente->id, 'valor' => $cliente->plano->valor]
            );
        }

        return $mensalidade;
    }

    /**
     * Register a payment for a monthly bill.
     */
    public function registrarPagamento(Mensalidade $mensalidade, float $valor, ?Carbon $dataPagamento = null): void
    {
        $mensalidade->update([
            'status' => 'pago',
        ]);

        $mensalidade->pagamentos()->create([
            'valor' => $valor,
            'data_pagamento' => $dataPagamento ?? now(),
        ]);

        $this->atualizarStatusCliente($mensalidade->cliente);

        LogService::registrar(
            'Financeiro',
            'Baixa de Mensalidade',
            "Recebimento registrado para {$mensalidade->cliente->nome} no valor de R$ ".number_format($valor, 2, ',', '.'),
            ['mensalidade_id' => $mensalidade->id, 'valor' => $valor]
        );
    }

    /**
     * Update client status based on delayed payments.
     */
    public function atualizarStatusCliente(Cliente $cliente): void
    {
        $hasAtraso = $cliente->mensalidades()
            ->where('status', 'atrasado')
            ->exists();

        $cliente->update([
            'status' => $hasAtraso ? 'inadimplente' : 'ativo',
        ]);
        LogService::registrar(
            'Financeiro',
            'Atualização de Status do Cliente',
            "Status do cliente {$cliente->nome} atualizado para {$cliente->status}",
            ['cliente_id' => $cliente->id, 'status' => $cliente->status]
        );
    }

    /**
     * Mark pending payments as delayed if past due date.
     */
    public function marcarAtrasos(): int
    {
        return Mensalidade::where('status', 'pendente')
            ->whereDate('vencimento', '<', now())
            ->update(['status' => 'atrasado']);
    }
}
