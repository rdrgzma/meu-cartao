<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Pagamento; // <-- Trocado de Mensalidade para Pagamento
use App\Models\Parceiro;
use Illuminate\Support\Facades\DB;

class RelatorioService
{
    /**
     * Get statistics for the administrative dashboard.
     */
    public function statsAdmin(): array
    {
        return [
            'clientes_ativos' => Cliente::where('status', 'ativo')->count(),
            'clientes_inadimplentes' => Cliente::where('status', 'inadimplente')->count(),
            
            // Corrigido para somar o 'valor' na tabela de Pagamentos
            'faturamento_mes' => (float) Pagamento::whereMonth('data_pagamento', now()->month)
                ->whereYear('data_pagamento', now()->year)
                ->sum('valor'),
                
            'parceiros_ativos' => Parceiro::where('status', 'ativo')->count(),
            'cresciment_mensal' => $this->calcularCrescimento(),
        ];
    }

    protected function calcularCrescimento(): float
    {
        $mesAtual = Cliente::whereMonth('created_at', now()->month)->count();
        $mesAnterior = Cliente::whereMonth('created_at', now()->subMonth()->month)->count();

        if ($mesAnterior === 0) {
            return $mesAtual > 0 ? 100 : 0;
        }

        return (($mesAtual - $mesAnterior) / $mesAnterior) * 100;
    }

    /**
     * Get revenue chart data.
     */
    public function faturamentoPorMes(): array
    {
        // Corrigido para modelo Pagamento e ajustado strftime para sintaxe MySQL
        return Pagamento::select(
            DB::raw('MONTH(data_pagamento) as mes'),
            DB::raw('SUM(valor) as total')
        )
            ->whereNotNull('data_pagamento')
            ->whereYear('data_pagamento', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->toArray();
    }
}
