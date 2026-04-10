<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use App\Services\ClienteService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusReserva = ''; // Renomeado para evitar conflito se houver status em outros lugares, mas usarei 'status'

    public string $status = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    protected $listeners = ['clienteUpdated' => '$refresh'];

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

    public function delete(int $id, ClienteService $service): void
    {
        $cliente = Cliente::findOrFail($id);
        $service->delete($cliente);

        $this->dispatch('notify',
            title: 'Excluído',
            description: 'Cliente removido com sucesso.',
            type: 'success'
        );
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-cliente', id: $id);
        $this->dispatch('open-modal', 'cliente-modal');
    }

    public function create(): void
    {
        $this->dispatch('reset-form');
        $this->dispatch('open-modal', 'cliente-modal');
    }

    public function abrirCarteira(int $id): void
    {
        $this->dispatch('show-carteira', id: $id);
        $this->dispatch('open-modal', 'carteira-modal');
    }

    public function render(ClienteService $service)
    {
        return view('livewire.cliente.index', [
            'clientes' => $service->paginate(
                10,
                $this->search,
                $this->status,
                $this->dataInicio,
                $this->dataFim
            ),
        ]);
    }
}
