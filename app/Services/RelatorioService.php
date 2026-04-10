<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Mensalidade;
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
            'faturamento_mes' => (float) Mensalidade::whereMonth('data_pagamento', now()->month)
                ->whereYear('data_pagamento', now()->year)
                ->sum('valor_pago'),
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
        return Mensalidade::select(
            DB::raw('strftime("%m", data_pagamento) as mes'),
            DB::raw('SUM(valor_pago) as total')
        )
            ->whereNotNull('data_pagamento')
            ->whereYear('data_pagamento', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->toArray();
    }
}
