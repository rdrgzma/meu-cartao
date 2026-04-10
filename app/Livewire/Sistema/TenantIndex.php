<?php

namespace App\Livewire\Sistema;

use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithPagination;

class TenantIndex extends Component
{
    use WithPagination;

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
