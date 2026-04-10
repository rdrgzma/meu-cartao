<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\ClienteToken;
use App\Services\ValidadorElegibilidadeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ValidacaoController extends Controller
{
    public function __construct(
        protected ValidadorElegibilidadeService $validador
    ) {}

    /**
     * Valida elegibilidade do cliente.
     */
    public function validar(Request $request): JsonResponse
    {
        $request->validate([
            'identificacao' => ['required', 'string'], // CPF ou ID
            'especialidade_id' => ['required', 'integer', 'exists:especialidades,id'],
        ]);

        $cliente = Cliente::query()
            ->where('cpf', $request->identificacao)
            ->orWhere('id', $request->identificacao)
            ->first();

        if (! $cliente) {
            return response()->json([
                'status' => 'nao_encontrado',
                'mensagem' => 'Cliente não encontrado.',
            ], 404);
        }

        $resultado = $this->validador->validar($cliente, (int) $request->especialidade_id);

        return response()->json([
            'cliente' => [
                'nome' => $cliente->nome,
                'status' => $cliente->status,
            ],
            'resultado' => $resultado,
        ]);
    }

    /**
     * Valida elegibilidade via token do QR Code.
     */
    public function validarToken(string $token): JsonResponse
    {
        $tokenRecord = ClienteToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (! $tokenRecord) {
            return response()->json([
                'status' => 'token_invalido',
                'mensagem' => 'Token expirado ou inválido.',
            ], 403);
        }

        $cliente = $tokenRecord->cliente;

        // Retorna status geral do cliente e do plano
        return response()->json([
            'cliente' => $cliente->only('nome', 'cpf', 'status'),
            'plano' => [
                'nome' => $cliente->plano?->nome,
                'cobertura' => $cliente->plano?->especialidades->map(fn ($esp) => [
                    'nome' => $esp->nome,
                    'status' => $this->validador->validar($cliente, $esp->id)['status'],
                ]),
            ],
        ]);
    }
}
