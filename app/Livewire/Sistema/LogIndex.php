<?php

namespace App\Livewire\Sistema;

use App\Models\AtividadeLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class LogIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $modulo = '';

    public ?AtividadeLog $selectedLog = null;

    public function showDetails(int $id): void
    {
        $this->selectedLog = AtividadeLog::find($id);
        $this->dispatch('open-modal', 'log-details');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingModulo(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = AtividadeLog::query()
            ->with(['user', 'tenant'])
            ->when($this->search, function ($q) {
                $q->where('descricao', 'like', "%{$this->search}%")
                    ->orWhere('acao', 'like', "%{$this->search}%");
            })
            ->when($this->modulo, fn ($q) => $q->where('modulo', $this->modulo))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.sistema.log-index', [
            'logs' => $logs,
        ]);
    }
}
