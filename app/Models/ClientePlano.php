<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientePlano extends Model
{
    protected $fillable = [
        'cliente_id',
        'plano_id',
        'inicio',
        'fim'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }
}
