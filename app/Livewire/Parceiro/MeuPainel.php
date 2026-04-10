<?php

namespace App\Livewire\Parceiro;

use App\Models\Atendimento;
use App\Models\Parceiro;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class MeuPainel extends Component
{
    public string $dataInicio = '';
    public string $dataFim = '';

    public function mount(): void
    {
        if (auth()->user()->funcao !== 'parceiro') {
            abort(403);
        }

        $this->dataInicio = now()->startOfMonth()->format('Y-m-d');
        $this->dataFim = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $parceiro = Parceiro::find(auth()->user()->parceiro_id);
        
        // Especialidades vinculadas pelo Admin
        $especialidades = $parceiro ? $parceiro->especialidades()->where('ativo', true)->get() : collect();

        // Quantidade de atendimentos por especialidade no período
        $atendimentosPorEspecialidade = Atendimento::query()
            ->where('parceiro_id', auth()->user()->parceiro_id)
            ->where('status', 'liberado')
            ->whereBetween('data_atendimento', [$this->dataInicio . ' 00:00:00', $this->dataFim . ' 23:59:59'])
            ->selectRaw('especialidade_id, count(*) as total')
            ->groupBy('especialidade_id')
            ->with('especialidade')
            ->get();

        return view('livewire.parceiro.meu-painel', [
            'parceiro' => $parceiro,
            'especialidades' => $especialidades,
            'atendimentos' => $atendimentosPorEspecialidade,
            'totalPeriodo' => $atendimentosPorEspecialidade->sum('total'),
        ]);
    }
}
