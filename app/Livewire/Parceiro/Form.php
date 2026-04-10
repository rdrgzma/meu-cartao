<?php

namespace App\Livewire\Parceiro;

use App\Models\Parceiro;
use App\Services\EspecialidadeService;
use App\Services\ParceiroService;
use Livewire\Component;
use Livewire\Attributes\On;

class Form extends Component
{
    #[On('reset-form')]
    public function resetFormListener(): void
    {
        $this->resetForm();
    }
    public ?Parceiro $parceiro = null;

    public ?string $nome_fantasia = '';
    public ?string $razao_social = '';
    public ?string $documento = '';
    public ?string $telefone = '';
    public ?string $endereco = '';
    public ?string $cidade = '';
    public ?string $estado = '';
    public ?string $status = 'ativo';

    public array $selectedEspecialidades = [];

    #[On('edit-parceiro')]
    public function edit(int $id): void
    {
        $this->parceiro = Parceiro::with('especialidades')->findOrFail($id);
        $this->nome_fantasia = $this->parceiro->nome_fantasia ?? '';
        $this->razao_social = $this->parceiro->razao_social ?? '';
        $this->documento = $this->parceiro->documento ?? '';
        $this->telefone = $this->parceiro->telefone ?? '';
        $this->endereco = $this->parceiro->endereco ?? '';
        $this->cidade = $this->parceiro->cidade ?? '';
        $this->estado = $this->parceiro->estado ?? '';
        $this->status = $this->parceiro->status ?? 'ativo';
        $this->selectedEspecialidades = $this->parceiro->especialidades->pluck('id')->map(fn ($id) => (string) $id)->toArray();

        $this->resetErrorBag();
    }

    public function resetForm(): void
    {
        $this->reset(['parceiro', 'nome_fantasia', 'razao_social', 'documento', 'telefone', 'endereco', 'cidade', 'estado', 'selectedEspecialidades']);
        $this->status = 'ativo';
        $this->resetErrorBag();
    }

    public function save(ParceiroService $service, bool $stay = false): void
    {
        $rules = [
            'nome_fantasia' => ['required', 'string', 'max:255'],
            'razao_social' => ['nullable', 'string', 'max:255'],
            'documento' => ['required', 'string'],
            'telefone' => ['required', 'string'],
            'endereco' => ['nullable', 'string'],
            'cidade' => ['required', 'string'],
            'estado' => ['required', 'string', 'size:2'],
            'status' => ['required', 'in:ativo,inativo'],
        ];

        $data = $this->validate($rules);

        try {
            if ($this->parceiro) {
                $service->update($this->parceiro, $data, $this->selectedEspecialidades);
                $msg = 'Parceiro atualizado com sucesso.';
            } else {
                $service->criar($data, $this->selectedEspecialidades);
                $msg = 'Parceiro cadastrado com sucesso.';
            }

            $this->dispatch('parceiroUpdated');
            
            if (! $stay) {
                $this->dispatch('close-modal');
            }

            $this->dispatch('notify',
                title: 'Sucesso',
                description: $msg,
                type: 'success'
            );

            $this->resetForm();
        } catch (\Exception $e) {
            $this->addError('nome_fantasia', $e->getMessage());
        }
    }

    public function render(EspecialidadeService $service)
    {
        return view('livewire.parceiro.form', [
            'especialidades' => $service->getActive(),
        ]);
    }
}
