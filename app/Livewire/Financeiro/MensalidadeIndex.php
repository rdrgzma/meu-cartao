<?php

namespace App\Livewire\Financeiro;

use App\Services\FinanceiroService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class MensalidadeIndex extends Component
{
    use WithPagination;
    
    public function mount(): void
    {
        if (auth()->user()->funcao === 'parceiro' && !auth()->user()->can_access_financeiro) {
            abort(403, 'Acesso restrito ao Financeiro.');
        }
    }

    public string $search = '';

    public string $status = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    protected $listeners = ['pagamentoRegistrado' => '$refresh'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
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

    public function marcarAtrasos(FinanceiroService $service): void
    {
        $count = $service->marcarAtrasos();

        $this->dispatch('notify',
            title: 'Processamento concluído',
            description: "{$count} mensalidades marcadas como atrasadas.",
            type: 'info'
        );
    }

    public function render(FinanceiroService $service)
    {
        return view('livewire.financeiro.mensalidade-index', [
            'mensalidades' => $service->paginate(
                10,
                $this->search,
                $this->status,
                $this->dataInicio,
                $this->dataFim
            ),
        ]);
    }
}
