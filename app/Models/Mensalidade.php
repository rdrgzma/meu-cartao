<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensalidade extends Model
{
    use HasFactory, Tenantable;

    protected $fillable = [
        'tenant_id', 'cliente_id', 'valor', 'vencimento', 'status',
    ];

    protected function casts(): array
    {
        return [
            'vencimento' => 'date',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

    public function getValorPagoAttribute(): float
    {
        return (float) $this->pagamentos->sum('valor');
    }

    public function getDataPagamentoAttribute()
    {
        return $this->pagamentos->max('data_pagamento');
    }
}
