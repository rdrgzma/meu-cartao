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
            ->with(['cliente', 'cliente.plano'])
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
        return Mensalidade::create([
            'cliente_id' => $cliente->id,
            'valor' => $cliente->plano->valor,
            'vencimento' => $vencimento ?? now()->addMonth(),
            'status' => 'pendente',
        ]);
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
