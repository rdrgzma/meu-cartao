<?php

namespace App\Livewire\Validacao;

use App\Models\Cliente;
use App\Models\Especialidade;
use App\Services\ValidadorElegibilidadeService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Painel extends Component
{
    public string $search = '';

    public ?Cliente $cliente = null;

    public ?int $selectedEspecialidadeId = null;

    public ?array $resultado = null;

    public function updatedSearch(): void
    {
        if (strlen($this->search) < 3) {
            $this->cliente = null;
            $this->resultado = null;

            return;
        }

        $this->cliente = Cliente::query()
            ->where('cpf', $this->search)
            ->orWhere('id', $this->search) // número da carteira
            ->first();

        if ($this->cliente) {
            $this->resultado = null;
        }
    }

    public function validar(ValidadorElegibilidadeService $service): void
    {
        $this->validate([
            'selectedEspecialidadeId' => ['required', 'exists:especialidades,id'],
        ]);

        $this->resultado = $service->validar($this->cliente, $this->selectedEspecialidadeId);
    }

    public function render()
    {
        return view('livewire.validacao.painel', [
            'especialidades' => Especialidade::where('ativo', true)->orderBy('nome')->get(),
        ]);
    }
}
