<?php

namespace App\Services;

use App\Models\AtividadeLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogService
{
    /**
     * Registra uma atividade no log do sistema.
     */
    public static function registrar(string $modulo, string $acao, string $descricao, ?array $dados = null): AtividadeLog
    {
        return AtividadeLog::create([
            'user_id' => Auth::id(),
            'modulo' => $modulo,
            'acao' => $acao,
            'descricao' => $descricao,
            'dados' => $dados,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
