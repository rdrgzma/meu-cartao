<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'mensalidade_id','valor','data_pagamento','metodo'
    ];

    public function mensalidade()
    {
        return $this->belongsTo(Mensalidade::class);
    }
}
