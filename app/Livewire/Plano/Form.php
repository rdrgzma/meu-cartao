<?php

namespace App\Livewire\Plano;

use App\Models\Plano;
use App\Services\EspecialidadeService;
use App\Services\PlanoService;
use Livewire\Component;
use Livewire\Attributes\On;

class Form extends Component
{
    #[On('reset-form')]
    public function resetFormListener(): void
    {
        $this->resetForm();
    }
    public ?Plano $plano = null;

    public ?string $nome = '';

    public float $valor = 0.0;

    public bool $ativo = true;

    public array $selectedEspecialidades = [];

    public array $carencias = []; // [especialidade_id => dias]

    #[On('edit-plano')]
    public function edit(int $id): void
    {
        $this->plano = Plano::with(['especialidades', 'carencias'])->findOrFail($id);
        $this->nome = $this->plano->nome ?? '';
        $this->valor = (float) ($this->plano->valor ?? 0);
        $this->ativo = (bool) ($this->plano->ativo ?? true);

        $this->selectedEspecialidades = $this->plano->especialidades->pluck('id')->map(fn ($id) => (string) $id)->toArray();

        $this->carencias = [];
        foreach ($this->plano->carencias as $carencia) {
            $this->carencias[$carencia->especialidade_id] = $carencia->dias;
        }

        $this->resetErrorBag();
    }

    public function resetForm(): void
    {
        $this->reset(['plano', 'nome', 'valor', 'ativo', 'selectedEspecialidades', 'carencias']);
        $this->resetErrorBag();
    }

    public function save(PlanoService $service, bool $stay = false): void
    {
        $rules = [
            'nome' => ['required', 'string', 'max:255'],
            'valor' => ['required', 'numeric', 'min:0'],
            'ativo' => ['required', 'boolean'],
            'selectedEspecialidades' => ['required', 'array', 'min:1'],
            'carencias.*' => ['nullable', 'integer', 'min:0'],
        ];

        $data = $this->validate($rules);

        try {
            if ($this->plano) {
                // Update implementation depends on service, assuming it handles sync
                $service->update($this->plano, $data, $this->selectedEspecialidades, $this->carencias);
                $msg = 'Plano atualizado com sucesso.';
            } else {
                $service->criar($data, $this->selectedEspecialidades, $this->carencias);
                $msg = 'Plano cadastrado com sucesso.';
            }

            $this->dispatch('planoUpdated');
            
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

    public function render(EspecialidadeService $espService)
    {
        return view('livewire.plano.form', [
            'especialidades' => $espService->getActive(),
        ]);
    }
}
