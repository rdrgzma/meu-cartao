<?php

namespace App\Livewire\Relatorio;

use App\Models\Mensalidade;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Financeiro extends Component
{
    use WithPagination;

    public string $dataInicio = '';

    public string $dataFim = '';

    public string $status = '';

    public function mount(): void
    {
        if (auth()->user()->funcao === 'parceiro' && !auth()->user()->can_access_relatorios) {
            abort(403, 'Acesso restrito ao Relatório Financeiro.');
        }

        $this->dataInicio = now()->startOfMonth()->format('Y-m-d');
        $this->dataFim = now()->endOfMonth()->format('Y-m-d');
    }

    public function exportCsv(): void
    {
        // Registro de log de exportação (Sprint 6 requirement)
        logger('Exportação de relatório financeiro por '.auth()->user()->name);

        $this->dispatch('notify',
            title: 'Exportação Iniciada',
            description: 'O arquivo CSV será gerado e enviado para seu e-mail.',
            type: 'success'
        );
    }

public function render()
    {
        $vendas = Mensalidade::query()
            ->with('cliente')
            ->when($this->dataInicio, fn ($q) => $q->where('vencimento', '>=', $this->dataInicio))
            ->when($this->dataFim, fn ($q) => $q->where('vencimento', '<=', $this->dataFim))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy('vencimento', 'desc')
            ->paginate(15);

        return view('livewire.relatorio.financeiro', [
            'vendas' => $vendas,
        ]);
    }
}
