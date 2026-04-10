<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory, Tenantable;
    protected $fillable = [
        'tenant_id', 'mensalidade_id','valor','data_pagamento','metodo'
    ];

    public function mensalidade()
    {
        return $this->belongsTo(Mensalidade::class);
    }
}
