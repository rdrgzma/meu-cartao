<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacaoLog extends Model
{
    use Tenantable;

    protected $fillable = [
        'tenant_id',
        'cliente_id',
        'tipo',
        'conteudo',
        'status',
        'canal',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
