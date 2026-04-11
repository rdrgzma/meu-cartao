<?php

namespace App\Livewire\Financeiro;

use App\Models\Mensalidade;
use App\Services\FinanceiroService;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class BaixaModal extends Component
{
    public ?Mensalidade $mensalidade = null;

    public float $valor_pago = 0.0;

    public string $data_pagamento = '';

    public function mount(): void
    {
        $this->data_pagamento = now()->format('Y-m-d');
    }

    #[On('setMensalidade')]
    public function setMensalidade(int $id): void
    {
        $this->mensalidade = Mensalidade::findOrFail($id);
        $this->valor_pago = (float) $this->mensalidade->valor;
        $this->resetErrorBag();
    }

    public function save(FinanceiroService $service): void
    {
        if (! $this->mensalidade) {
            return;
        }

        $this->validate([
            'valor_pago' => ['required', 'numeric', 'min:0'],
            'data_pagamento' => ['required', 'date'],
        ]);

        $service->registrarPagamento(
            $this->mensalidade,
            $this->valor_pago,
            Carbon::parse($this->data_pagamento)
        );

        $this->dispatch('pagamentoRegistrado');
        $this->dispatch('modal-close', name: 'baixa-modal');

        $this->dispatch('notify',
            title: 'Sucesso',
            description: 'Pagamento registrado com sucesso.',
            type: 'success'
        );

        $this->reset(['mensalidade', 'valor_pago']);
        $this->data_pagamento = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.financeiro.baixa-modal');
    }
}
