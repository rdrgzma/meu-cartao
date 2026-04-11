<?php

namespace App\Livewire\Financeiro;

use App\Services\FinanceiroService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class MensalidadeIndex extends Component
{
    use WithPagination;

    public function mount(): void
    {
        if (auth()->user()->funcao === 'parceiro' && ! auth()->user()->can_access_financeiro) {
            abort(403, 'Acesso restrito ao Financeiro.');
        }
    }

    public string $search = '';

    public string $status = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    #[On('pagamentoRegistrado')]
    public function refreshList(): void
    {
        // O Livewire já atualiza o estado, mas podemos forçar se necessário
    }

    public function darBaixa(int $id): void
    {
        $this->dispatch('setMensalidade', id: $id)->to(BaixaModal::class);
        $this->dispatch('open-modal', 'baixa-modal');
    }

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
