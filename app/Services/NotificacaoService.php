<?php

namespace App\Services;

use App\Models\Cliente;

class NotificacaoService
{
    public function enviarLembretePagamento(Cliente $cliente): void
    {
        // integrar com WhatsApp futuramente
        logger("Lembrete enviado para {$cliente->telefone}");
    }

    public function enviarAvisoAtraso(Cliente $cliente): void
    {
        logger("Aviso de atraso para {$cliente->telefone}");
    }
}