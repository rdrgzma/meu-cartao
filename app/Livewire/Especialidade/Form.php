<?php

namespace App\Livewire\Especialidade;

use App\Models\Especialidade;
use App\Services\EspecialidadeService;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    #[On('reset-form')]
    public function resetFormListener(): void
    {
        $this->resetForm();
    }

    public ?Especialidade $especialidade = null;

    public ?string $nome = '';

    public bool $ativo = true;

    #[On('edit-especialidade')]
    public function edit(int $id): void
    {
        $this->especialidade = Especialidade::findOrFail($id);
        $this->nome = $this->especialidade->nome ?? '';
        $this->ativo = (bool) ($this->especialidade->ativo ?? true);

        $this->resetErrorBag();
    }

    public function resetForm(): void
    {
        $this->reset(['especialidade', 'nome', 'ativo']);
        $this->resetErrorBag();
    }

    public function save(EspecialidadeService $service, bool $stay = false): void
    {
        $rules = [
            'nome' => ['required', 'string', 'max:255'],
            'ativo' => ['required', 'boolean'],
        ];

        $data = $this->validate($rules);

        try {
            if ($this->especialidade) {
                $service->update($this->especialidade, $data);
                $msg = 'Especialidade atualizada com sucesso.';
            } else {
                if (auth()->user()->funcao === 'parceiro') {
                    $data['ativo'] = false;
                }
                $service->create($data);
                $msg = auth()->user()->funcao === 'parceiro'
                    ? 'Especialidade sugerida com sucesso. Aguardando ativação pelo administrador.'
                    : 'Especialidade cadastrada com sucesso.';
            }

            $this->dispatch('especialidadeUpdated');

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
            $this->addError('nome', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.especialidade.form');
    }
}
