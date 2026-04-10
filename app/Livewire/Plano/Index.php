<?php

namespace App\Livewire\Plano;

use App\Models\Plano;
use App\Services\PlanoService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    protected $listeners = ['planoUpdated' => '$refresh'];

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

    public function delete(int $id, PlanoService $service): void
    {
        $plano = Plano::findOrFail($id);
        $service->delete($plano);

        $this->dispatch('notify',
            title: 'Excluído',
            description: 'Plano removido com sucesso.',
            type: 'success'
        );
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-plano', id: $id);
        $this->dispatch('open-modal', 'plano-modal');
    }

    public function create(): void
    {
        $this->dispatch('reset-form');
        $this->dispatch('open-modal', 'plano-modal');
    }

    public function render(PlanoService $service)
    {
        return view('livewire.plano.index', [
            'planos' => $service->paginate(
                10,
                $this->search,
                $this->status,
                $this->dataInicio,
                $this->dataFim
            ),
        ]);
    }
}
