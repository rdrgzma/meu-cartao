<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Notificacao;
use App\Models\NotificacaoLog;
use Illuminate\Support\Facades\Http;

class NotificacaoService
{
    /**
     * Envia uma notificação baseada em um template.
     */
    public function enviar(Cliente $cliente, string $tipo, array $variaveis = []): void
    {
        $notificacao = Notificacao::where('tipo', $tipo)->where('ativo', true)->first();

        if (! $notificacao) {
            // Se não houver template configurado, usa um padrão ou ignora
            $conteudo = "Olá {$cliente->nome}, esta é uma notificação automática.";
        } else {
            $conteudo = $this->parseTemplate($notificacao->template, array_merge([
                'nome' => $cliente->nome,
                'cpf' => $cliente->cpf,
                'telefone' => $cliente->telefone,
            ], $variaveis));
        }

        // Mock de integração com API de WhatsApp
        $this->dispararMensagem($cliente, $conteudo, $tipo);
    }

    protected function parseTemplate(string $template, array $variaveis): string
    {
        foreach ($variaveis as $key => $value) {
            $template = str_replace('{{'.$key.'}}', $value, $template);
        }

        return $template;
    }

    protected function dispararMensagem(Cliente $cliente, string $conteudo, string $tipo): void
    {
        // Registro no Log
        NotificacaoLog::create([
            'cliente_id' => $cliente->id,
            'tipo' => $tipo,
            'conteudo' => $conteudo,
            'status' => 'enviado',
            'canal' => 'whatsapp',
            'metadata' => ['envio' => now()->toDateTimeString()],
        ]);

        // Simulação de chamada de API
        // Http::post('https://api.whatsapp.com/send', [...]);
        logger("WhatsApp enviado para {$cliente->telefone}: {$conteudo}");
    }

    public function enviarLembretePagamento(Cliente $cliente, $valor, $vencimento): void
    {
        $this->enviar($cliente, 'lembrete_pagamento', [
            'valor' => $valor,
            'vencimento' => $vencimento,
        ]);
    }

    public function enviarAvisoAtraso(Cliente $cliente, $diasAtraso): void
    {
        $this->enviar($cliente, 'aviso_atraso', [
            'dias_atraso' => $diasAtraso,
        ]);
    }
}
