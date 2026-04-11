<?php

namespace App\Livewire\Sistema;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.app')]
class UserIndex extends Component
{
    use WithPagination;

    #[On('userUpdated')]
    public function refresh(): void
    {
        // Apenas para forçar renderização
    }
    
    public function mount(): void
    {
        if (!in_array(auth()->user()->funcao, ['sistema', 'admin'])) {
            abort(403, 'Acesso restrito.');
        }
    }

    public string $search = '';

    public string $status = '';

    public string $tipo = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedTipo(): void
    {
        $this->resetPage();
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-user', id: $id);
        $this->dispatch('open-modal', 'user-modal');
    }

    public function create(): void
    {
        $this->dispatch('reset-form');
        $this->dispatch('open-modal', 'user-modal');
    }

    protected function getUsers()
    {
        return User::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->tipo, fn ($q) => $q->where('tipo', $this->tipo))
            ->with('tenant')
            ->orderBy('name')
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.sistema.user-index', [
            'users' => $this->getUsers(),
        ]);
    }
}
