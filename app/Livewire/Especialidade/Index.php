<?php

namespace App\Livewire\Especialidade;

use App\Models\Especialidade;
use App\Services\EspecialidadeService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    
    public function mount(): void
    {
        if (auth()->user()->funcao === 'parceiro' && !auth()->user()->can_access_especialidades) {
            abort(403, 'Acesso restrito às Especialidades.');
        }
    }

    public string $search = '';

    public string $status = '';

    public string $dataInicio = '';

    public string $dataFim = '';

    protected $listeners = ['especialidadeUpdated' => '$refresh'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedDataInicio(): void
    {
        $this->resetPage();
    }

    public function updatedDataFim(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(int $id, EspecialidadeService $service): void
    {
        if (auth()->user()->funcao === 'parceiro') {
            abort(403, 'Ação não permitida para parceiros.');
        }

        $especialidade = Especialidade::findOrFail($id);
        $service->toggleStatus($especialidade);

        $this->dispatch('notify',
            title: 'Status atualizado',
            description: "Especialidade {$especialidade->nome} ".($especialidade->ativo ? 'ativada' : 'desativada'),
            type: 'success'
        );
    }

    public function delete(int $id, EspecialidadeService $service): void
    {
        if (auth()->user()->funcao === 'parceiro') {
            abort(403, 'Ação não permitida para parceiros.');
        }

        $especialidade = Especialidade::findOrFail($id);
        $service->delete($especialidade);

        $this->dispatch('notify',
            title: 'Excluído',
            description: 'Especialidade removida com sucesso.',
            type: 'success'
        );
    }

    public function edit(int $id): void
    {
        $this->dispatch('edit-especialidade', id: $id);
        $this->dispatch('open-modal', 'especialidade-modal');
    }

    public function create(): void
    {
        $this->dispatch('reset-form');
        $this->dispatch('open-modal', 'especialidade-modal');
    }

    public function render(EspecialidadeService $service)
    {
        return view('livewire.especialidade.index', [
            'especialidades' => $service->paginate(
                10,
                $this->search,
                $this->status,
                $this->dataInicio,
                $this->dataFim
            ),
        ]);
    }
}
