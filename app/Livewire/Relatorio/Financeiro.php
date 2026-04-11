<?php

namespace App\Livewire\Relatorio;

use App\Models\Mensalidade;
use App\Services\LogService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Financeiro extends Component
{
    use WithPagination;

    public string $dataInicio = '';

    public string $dataFim = '';

    public string $status = '';

    public function mount(): void
    {
        if (auth()->user()->funcao === 'parceiro' && ! auth()->user()->can_access_relatorios) {
            abort(403, 'Acesso restrito ao Relatório Financeiro.');
        }

        $this->dataInicio = now()->startOfMonth()->format('Y-m-d');
        $this->dataFim = now()->endOfMonth()->format('Y-m-d');
    }

    public function exportCsv()
    {
        // Registro de log de auditoria
        LogService::registrar(
            'Sistema',
            'Exportação de Relatório',
            'Relatório financeiro exportado por '.auth()->user()->name
        );

        $fileName = 'relatorio-financeiro-'.now()->format('YmdHis').'.csv';

        $query = Mensalidade::query()
            ->with(['cliente', 'pagamentos', 'tenant'])
            ->when($this->dataInicio, fn ($q) => $q->where('vencimento', '>=', $this->dataInicio))
            ->when($this->dataFim, fn ($q) => $q->where('vencimento', '<=', $this->dataFim))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy('vencimento', 'desc');

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($query) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Unidade',
                'Cliente',
                'CPF',
                'Vencimento',
                'Status',
                'Valor Original',
                'Valor Pago',
                'Data Pagamento',
            ], ';');

            $query->chunk(100, function ($mensalidades) use ($file) {
                foreach ($mensalidades as $m) {
                    $dataPagamento = $m->pagamentos->max('data_pagamento');

                    fputcsv($file, [
                        $m->tenant?->nome ?? '-',
                        $m->cliente?->nome,
                        $m->cliente?->cpf,
                        $m->vencimento instanceof \Carbon\Carbon ? $m->vencimento->format('d/m/Y') : $m->vencimento,
                        ucfirst($m->status),
                        number_format($m->valor, 2, ',', '.'),
                        number_format($m->valor_pago, 2, ',', '.'),
                        $dataPagamento ? (is_string($dataPagamento) ? date('d/m/Y H:i', strtotime($dataPagamento)) : $dataPagamento->format('d/m/Y H:i')) : '-',
                    ], ';');
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $query = Mensalidade::query()
            ->with(['cliente', 'pagamentos', 'tenant'])
            ->when($this->dataInicio, fn ($q) => $q->where('vencimento', '>=', $this->dataInicio))
            ->when($this->dataFim, fn ($q) => $q->where('vencimento', '<=', $this->dataFim))
            ->when($this->status, fn ($q) => $q->where('status', $this->status));

        $totalRecebido = (clone $query)
            ->where('status', 'pago')
            ->get()
            ->sum(fn ($m) => $m->pagamentos->sum('valor'));

        $totalPendente = (clone $query)
            ->whereIn('status', ['pendente', 'atrasado'])
            ->sum('valor');

        $vendas = $query->orderBy('vencimento', 'desc')->paginate(15);

        return view('livewire.relatorio.financeiro', [
            'vendas' => $vendas,
            'totalRecebido' => $totalRecebido,
            'totalPendente' => $totalPendente,
        ]);
    }
}
