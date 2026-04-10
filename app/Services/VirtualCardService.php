<?php 
namespace App\Services;

use App\Models\Cliente;
use App\Models\ClienteToken;
use Illuminate\Support\Str;

class VirtualCardService
{
    protected ValidadorElegibilidadeService $validador;

    public function __construct(ValidadorElegibilidadeService $validador)
    {
        $this->validador = $validador;
    }

    public function gerarCarteira(Cliente $cliente): array
    {
        // Garante que as relações necessárias estão carregadas
        $cliente->load(['plano.especialidades', 'plano.carencias']);

        $token = $this->gerarOuRecuperarToken($cliente);

        return [
            'cliente' => [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
                'cns' => $cliente->cns,
                'cpf' => $cliente->cpf,
                'status' => $cliente->status,
            ],

            'plano' => [
                'nome' => $cliente->plano?->nome ?? 'Sem Plano',
            ],

            'qr_code' => route('api.validacao', [
                'token' => $token->token
            ]),

            'especialidades' => $this->mapearEspecialidades($cliente),
        ];
    }

    protected function gerarOuRecuperarToken(Cliente $cliente): ClienteToken
    {
        $token = ClienteToken::where('cliente_id', $cliente->id)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->first();

        if ($token) {
            return $token;
        }

        return ClienteToken::create([
            'cliente_id' => $cliente->id,
            'token' => Str::uuid(),
            'expires_at' => now()->addDays(30)
        ]);
    }

    protected function mapearEspecialidades(Cliente $cliente): array
    {
        if (! $cliente->plano || ! $cliente->plano->especialidades) {
            return [];
        }

        return $cliente->plano->especialidades->map(function ($esp) use ($cliente) {
            $validacao = $this->validador->validar($cliente, $esp->id);
            
            $carencia = $cliente->plano->carencias
                ->where('especialidade_id', $esp->id)
                ->first();

            return [
                'id' => $esp->id,
                'nome' => $esp->nome,
                'status' => $validacao['status'],
                'dias_carencia' => $carencia ? $carencia->dias : 0,
                'liberado_em' => $validacao['liberado_em'] ?? null,
            ];
        })->toArray();
    }
}