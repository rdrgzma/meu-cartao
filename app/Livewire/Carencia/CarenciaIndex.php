<?php

namespace App\Livewire\Carencia;

use App\Models\Cliente;
use App\Models\Especialidade;
use App\Services\CarenciaService;
use Livewire\Component;

class CarenciaIndex extends Component
{
    public string $search = '';

    public ?Cliente $cliente = null;

    public array $especialidadesStatus = [];

    public function updatedSearch(): void
    {
        if (strlen($this->search) < 3) {
            $this->cliente = null;
            $this->especialidadesStatus = [];

            return;
        }

        $this->cliente = Cliente::query()
            ->where('cpf', 'like', "%{$this->search}%")
            ->orWhere('nome', 'like', "%{$this->search}%")
            ->first();

        if ($this->cliente) {
            $this->loadStatus();
        } else {
            $this->especialidadesStatus = [];
        }
    }

    public function setCliente(int $id): void
    {
        $this->cliente = Cliente::findOrFail($id);
        $this->loadStatus();
    }

    protected function loadStatus(): void
    {
        if (! $this->cliente || ! $this->cliente->plano_id) {
            $this->especialidadesStatus = [];

            return;
        }

        $service = app(CarenciaService::class);
        $especialidades = Especialidade::where('ativo', true)->get();

        $this->especialidadesStatus = [];

        foreach ($especialidades as $esp) {
            $coberto = $this->cliente->plano->especialidades->contains($esp->id);
            $dataLiberacao = $service->calcularDataLiberacao($this->cliente, $esp->id);
            $status = 'não coberto';

            if ($coberto) {
                if ($dataLiberacao && now()->lt($dataLiberacao)) {
                    $status = 'em carência';
                } else {
                    $status = 'liberado';
                }
            }

            $this->especialidadesStatus[] = [
                'nome' => $esp->nome,
                'status' => $status,
                'data_liberacao' => $dataLiberacao ? $dataLiberacao->format('d/m/Y') : '-',
                'coberto' => $coberto,
            ];
        }
    }

    public function render()
    {
        return view('livewire.carencia.carencia-index');
    }
}
