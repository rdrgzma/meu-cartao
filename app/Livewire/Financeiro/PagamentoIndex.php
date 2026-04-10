<?php

namespace App\Livewire\Financeiro;

use App\Models\Pagamento;
use Livewire\Component;
use Livewire\WithPagination;

class PagamentoIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedDataInicio(): void
    {
        $this->resetPage();
    }

    public function updatedDataFim(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $pagamentos = Pagamento::query()
            ->with(['mensalidade', 'mensalidade.cliente'])
            ->when($this->search, function ($q) {
                $q->whereHas('mensalidade.cliente', fn ($query) => $query->where('nome', 'like', "%{$this->search}%"));
            })
            ->when($this->dataInicio, fn ($q) => $q->whereDate('data_pagamento', '>=', $this->dataInicio))
            ->when($this->dataFim, fn ($q) => $q->whereDate('data_pagamento', '<=', $this->dataFim))
            ->orderBy('data_pagamento', 'desc')
            ->paginate(15);

        return view('livewire.financeiro.pagamento-index', [
            'pagamentos' => $pagamentos,
        ]);
    }
}
