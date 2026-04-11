<?php

namespace App\Livewire\Sistema;

use App\Models\Tenant;
use App\Services\LogService;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class TenantForm extends Component
{
    public ?Tenant $tenant = null;

    public string $nome = '';
    public string $slug = '';
    public string $documento = '';
    public string $telefone = '';
    public string $endereco = '';
    public string $cidade = '';
    public string $estado = '';
    public string $status = 'ativo';

    #[On('edit-tenant')]
    public function loadTenant(int $id): void
    {
        $this->tenant = Tenant::findOrFail($id);
        $this->nome = $this->tenant->nome;
        $this->slug = $this->tenant->slug;
        $this->documento = $this->tenant->documento ?? '';
        $this->telefone = $this->tenant->telefone ?? '';
        $this->endereco = $this->tenant->endereco ?? '';
        $this->cidade = $this->tenant->cidade ?? '';
        $this->estado = $this->tenant->estado ?? '';
        $this->status = $this->tenant->status ?? 'ativo';

        $this->resetErrorBag();
    }

    #[On('reset-tenant-form')]
    public function resetForm(): void
    {
        $this->reset(['tenant', 'nome', 'slug', 'documento', 'telefone', 'endereco', 'cidade', 'estado', 'status']);
        $this->resetErrorBag();
    }

    public function delete(): void
    {
        if (auth()->user()->funcao !== 'sistema') {
            abort(403);
        }

        if ($this->tenant) {
            $nome = $this->tenant->nome;
            $this->tenant->delete();

            LogService::registrar(
                'Sistema',
                'Exclusão de Unidade',
                "Unidade {$nome} foi excluída (Soft Delete) por " . auth()->user()->name,
                ['tenant_id' => $this->tenant->id]
            );

            $this->dispatch('notify', title: 'Excluído', description: 'Unidade excluída com sucesso.', type: 'success');
            $this->dispatch('close-modal');
            $this->dispatch('tenantUpdated');
        }
    }

    public function updatedNome($value): void
    {
        if (!$this->tenant) {
            $this->slug = Str::slug($value);
        }
    }

    public function save(): void
    {
        if (auth()->user()->funcao !== 'sistema') {
            abort(403);
        }

        $rules = [
            'nome' => 'required|string|max:255',
            'slug' => $this->tenant ? 'required|string|unique:tenants,slug,'.$this->tenant->id : 'required|string|unique:tenants,slug',
            'documento' => 'nullable|string|max:20',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'status' => 'required|string|in:ativo,inativo',
        ];

        $data = $this->validate($rules);

        if ($this->tenant) {
            $this->tenant->update($data);
            $msg = 'Unidade atualizada com sucesso.';
            $logAction = 'Atualização de Unidade';
        } else {
            $this->tenant = Tenant::create($data);
            $msg = 'Nova unidade cadastrada com sucesso.';
            $logAction = 'Cadastro de Unidade';
        }

        LogService::registrar(
            'Sistema',
            $logAction,
            "{$logAction}: {$this->tenant->nome} por " . auth()->user()->name,
            ['tenant_id' => $this->tenant->id]
        );

        $this->dispatch('notify', title: 'Sucesso', description: $msg, type: 'success');
        $this->dispatch('close-modal');
        $this->dispatch('tenantUpdated');
    }

    public function render()
    {
        return view('livewire.sistema.tenant-form');
    }
}
