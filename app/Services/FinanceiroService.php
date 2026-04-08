<?phpnamespace App\Services;

use App\Models\Cliente;
use App\Models\Mensalidade;
use Carbon\Carbon;

class FinanceiroService
{
    public function gerarMensalidade(Cliente $cliente): Mensalidade
    {
        return Mensalidade::create([
            'cliente_id' => $cliente->id,
            'valor' => $cliente->plano->valor,
            'vencimento' => now()->addMonth(),
            'status' => 'pendente'
        ]);
    }

    public function registrarPagamento(Mensalidade $mensalidade, float $valor): void
    {
        $mensalidade->update([
            'status' => 'pago'
        ]);

        $mensalidade->pagamentos()->create([
            'valor' => $valor,
            'data_pagamento' => now()
        ]);

        $this->atualizarStatusCliente($mensalidade->cliente);
    }

    public function atualizarStatusCliente(Cliente $cliente): void
    {
        $temAtraso = $cliente->mensalidades()
            ->where('status', 'atrasado')
            ->exists();

        $cliente->update([
            'status' => $temAtraso ? 'inadimplente' : 'ativo'
        ]);
    }

    public function marcarAtraso(): void
    {
        Mensalidade::where('status', 'pendente')
            ->whereDate('vencimento', '<', now())
            ->update(['status' => 'atrasado']);
    }
}