<?php

namespace App\Livewire\Parceiro;

use App\Models\Parceiro;
use App\Services\ParceiroService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    protected $listeners = ['parceiroUpdated' => '$refresh'];

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

    public function toggleStatus(int $id, ParceiroService $service): void
    {
        $parceiro = Parceiro::findOrFail($id);
        $service->toggleStatus($parceiro);

        $this->dispatch('notify',
            title: 'Status atualizado',
            description: "Parceiro {$parceiro->nome_fantasia} agora está ".($parceiro->status),
            type: 'success'
        );
    }

    public function delete(int $id, ParceiroService $service): void
    {
        $parceiro = Parceiro::findOrFail($id);
        $service->delete($parceiro);

        $this->dispatch('notify',
            title: 'Excluído',
            description: 'Parceiro removido com sucesso.',
            type: 'success'
        );
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-parceiro', id: $id);
        $this->dispatch('open-modal', 'parceiro-modal');
    }

    public function create(): void
    {
        $this->dispatch('reset-form');
        $this->dispatch('open-modal', 'parceiro-modal');
    }

    public function render(ParceiroService $service)
    {
        return view('livewire.parceiro.index', [
            'parceiros' => $service->paginate(
                10,
                $this->search,
                $this->status,
                $this->dataInicio,
                $this->dataFim
            ),
        ]);
    }
}
