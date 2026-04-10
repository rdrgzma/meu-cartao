<?php

namespace App\Livewire\Notificacao;

use App\Models\NotificacaoLog;
use Livewire\Component;
use Livewire\WithPagination;

class LogIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $logs = NotificacaoLog::query()
            ->with('cliente')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.notificacao.log-index', [
            'logs' => $logs,
        ]);
    }
}
