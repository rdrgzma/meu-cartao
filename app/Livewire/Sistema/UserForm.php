<?php

namespace App\Livewire\Sistema;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserForm extends Component
{
    public ?User $user = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?int $tenant_id = null;

    public string $funcao = 'cliente';

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
        $this->funcao = $this->user->funcao ?? 'cliente';
        $this->tenant_id = $this->user->tenant_id;
        $this->can_access_dashboard = (bool) $this->user->can_access_dashboard;
        $this->can_access_financeiro = (bool) $this->user->can_access_financeiro;
        $this->can_access_relatorios = (bool) $this->user->can_access_relatorios;
        $this->can_access_planos = (bool) $this->user->can_access_planos;
        $this->can_access_especialidades = (bool) $this->user->can_access_especialidades;

        $this->reset(['password', 'password_confirmation']);
        $this->resetErrorBag();
    }

    #[On('reset-form')]
    public function resetForm(): void
    {
        $this->reset([
            'user', 'name', 'email', 'funcao', 'tenant_id', 'password', 'password_confirmation',
            'can_access_dashboard', 'can_access_financeiro', 'can_access_relatorios', 'can_access_planos', 'can_access_especialidades'
        ]);
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $currentUser = auth()->user();
        $isSistema = $currentUser->funcao === 'sistema';
        $isAdmin = $currentUser->funcao === 'admin';

        $rules = [
            'name' => 'required|string|max:255',
            'email' => $this->user ? 'required|email|unique:users,email,'.$this->user->id : 'required|email|unique:users,email',
            'password' => $this->user ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'funcao' => 'required|string|in:sistema,admin,parceiro,cliente',
            'tenant_id' => $isSistema ? 'nullable|exists:tenants,id' : 'nullable',
            'can_access_dashboard' => 'boolean',
            'can_access_financeiro' => 'boolean',
            'can_access_relatorios' => 'boolean',
            'can_access_planos' => 'boolean',
            'can_access_especialidades' => 'boolean',
        ];

        // Restrição de Admin
        if ($isAdmin) {
            $this->tenant_id = $currentUser->tenant_id;
            if (!in_array($this->funcao, ['admin', 'parceiro', 'cliente'])) {
                $this->addError('funcao', 'Nível de acesso inválido para sua permissão.');
                return;
            }
        }

        $data = $this->validate($rules);

        if ($this->password) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($this->password);
        } else {
            unset($data['password']);
        }
        
        unset($data['password_confirmation']);

        if ($this->user) {
            $this->user->update($data);
            $msgAction = 'atualizado';
            $logAcao = 'Atualização de Usuário';
        } else {
            $this->user = User::create($data);
            $msgAction = 'cadastrado';
            $logAcao = 'Novo Usuário';
        }

        LogService::registrar(
            'Sistema',
            $logAcao,
            "Usuário {$this->user->name} foi {$msgAction} por {$currentUser->name}.",
            ['managed_user_id' => $this->user->id, 'funcao' => $this->funcao]
        );

        $this->dispatch('notify',
            title: 'Sucesso',
            description: "Usuário {$msgAction} com sucesso.",
            type: 'success'
        );

        $this->dispatch('close-modal');
        $this->dispatch('userUpdated');
    }

    public function render()
    {
        return view('livewire.sistema.user-form', [
            'tenants' => auth()->user()->funcao === 'sistema' ? \App\Models\Tenant::orderBy('nome')->get() : [],
        ]);
    }
}
