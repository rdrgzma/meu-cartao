<?php

namespace App\Livewire\Relatorio;

use App\Models\Mensalidade;
use Livewire\Component;
use Livewire\WithPagination;

class Financeiro extends Component
{
    use WithPagination;

    public string $dataInicio = '';

    public string $dataFim = '';

    public string $status = '';

    public function mount(): void
    {
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
            ->when($this->dataInicio, fn ($q) => $q->where('data_pagamento', '>=', $this->dataInicio))
            ->when($this->dataFim, fn ($q) => $q->where('data_pagamento', '<=', $this->dataFim))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy('data_pagamento', 'desc')
            ->paginate(15);

        return view('livewire.relatorio.financeiro', [
            'vendas' => $vendas,
        ]);
    }
}
