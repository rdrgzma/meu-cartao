<?php

namespace App\Livewire\Sistema;

use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.app')]
class TenantIndex extends Component
{
    use WithPagination;

    #[On('tenantUpdated')]
    public function refresh(): void
    {
        // Forçar renderização
    }

    public function create(): void
    {
        $this->dispatch('reset-tenant-form');
        $this->dispatch('open-modal', 'tenant-modal');
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-tenant', id: $id);
        $this->dispatch('open-modal', 'tenant-modal');
    }
    
    public function mount(): void
    {
        if (auth()->user()->funcao !== 'sistema') {
            abort(403, 'Acesso restrito ao Administrador do Sistema.');
        }
    }

    public string $search = '';

    public string $cidade = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCidade(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $tenants = Tenant::query()
            ->when($this->search, function ($q) {
                $q->where('nome', 'like', "%{$this->search}%")
                    ->orWhere('documento', 'like', "%{$this->search}%");
            })
            ->when($this->cidade, fn ($q) => $q->where('cidade', 'like', "%{$this->cidade}%"))
            ->orderBy('nome')
            ->paginate(15);

        return view('livewire.sistema.tenant-index', [
            'tenants' => $tenants,
        ]);
    }
}
