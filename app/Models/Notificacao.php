<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use Tenantable;

    protected $table = 'notificacoes';

    protected $fillable = [
        'tenant_id',
        'tipo',
        'assunto',
        'template',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}
