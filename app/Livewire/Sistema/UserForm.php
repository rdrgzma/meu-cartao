<?php

namespace App\Livewire\Sistema;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class UserForm extends Component
{
    public ?User $user = null;
    public string $name = '';
    public string $email = '';
    public string $funcao = 'usuario';
    public bool $can_access_dashboard = false;
    public bool $can_access_financeiro = false;
    public bool $can_access_relatorios = false;
    public bool $can_access_planos = false;
    public bool $can_access_especialidades = false;

    #[On('edit-user')]
    public function loadUser(int $id): void
    {
        $this->user = User::findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->funcao = $this->user->funcao ?? 'usuario';
        $this->can_access_dashboard = (bool)$this->user->can_access_dashboard;
        $this->can_access_financeiro = (bool)$this->user->can_access_financeiro;
        $this->can_access_relatorios = (bool)$this->user->can_access_relatorios;
        $this->can_access_planos = (bool)$this->user->can_access_planos;
        $this->can_access_especialidades = (bool)$this->user->can_access_especialidades;

        $this->resetErrorBag();
    }

    #[On('reset-form')]
    public function resetForm(): void
    {
        $this->reset(['user', 'name', 'email', 'funcao', 'can_access_dashboard', 'can_access_financeiro', 'can_access_relatorios', 'can_access_planos', 'can_access_especialidades']);
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate([
            'funcao' => 'required|string|in:sistema,admin,parceiro,usuario',
            'can_access_dashboard' => 'boolean',
            'can_access_financeiro' => 'boolean',
            'can_access_relatorios' => 'boolean',
            'can_access_planos' => 'boolean',
            'can_access_especialidades' => 'boolean',
        ]);

        if ($this->user) {
            $this->user->update([
                'funcao' => $this->funcao,
                'can_access_dashboard' => $this->can_access_dashboard,
                'can_access_financeiro' => $this->can_access_financeiro,
                'can_access_relatorios' => $this->can_access_relatorios,
                'can_access_planos' => $this->can_access_planos,
                'can_access_especialidades' => $this->can_access_especialidades,
            ]);

            $this->dispatch('notify',
                title: 'Atualizado',
                description: 'Permissões do usuário atualizadas com sucesso.',
                type: 'success'
            );

            $this->dispatch('close-modal');
            $this->dispatch('userUpdated');
        }
    }

    public function render()
    {
        return view('livewire.sistema.user-form');
    }
}
