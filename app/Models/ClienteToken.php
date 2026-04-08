<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ClienteToken extends Model
{
    protected $fillable = [
        'cliente_id',
        'token',
        'expires_at'
    ];

    protected $dates = ['expires_at'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function isValido(): bool
    {
        return !$this->expires_at || now()->lt($this->expires_at);
    }
}
