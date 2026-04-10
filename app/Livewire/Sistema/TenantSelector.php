<?php

namespace App\Livewire\Sistema;

use App\Models\Tenant;
use Livewire\Component;

class TenantSelector extends Component
{
    public $tenants;

    public $selectedTenantId;

    public function mount()
    {
        $this->tenants = Tenant::orderBy('nome')->get();
        $this->selectedTenantId = session('simulated_tenant_id', '');
    }

    public function updatedSelectedTenantId($value)
    {
        if ($value === '') {
            session()->forget('simulated_tenant_id');
        } else {
            session(['simulated_tenant_id' => $value]);
        }

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.sistema.tenant-selector');
    }
}
