<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    use HasFactory, Tenantable;

    protected $fillable = [
        'tenant_id',
        'cliente_id',
        'parceiro_id',
        'user_id',
        'especialidade_id',
        'status',
        'data_atendimento'
    ];

    protected $casts = [
        'data_atendimento' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function parceiro()
    {
        return $this->belongsTo(Parceiro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
}
