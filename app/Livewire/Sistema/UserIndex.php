<?php

namespace App\Livewire\Sistema;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

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

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->tipo, fn ($q) => $q->where('tipo', $this->tipo))
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.sistema.user-index', [
            'users' => $users,
        ]);
    }
}
