<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Tenantable;

class Cliente extends Model
{
    use HasFactory, Tenantable;
 protected $fillable = [
    'tenant_id',
    'nome',
    'cpf',
    'cns', // novo campo
    'telefone',
    'email',
    'data_adesao',
    'status',
    'plano_id'
];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function mensalidades()
    {
        return $this->hasMany(Mensalidade::class);
    }
        public function historicoPlanos()
    {
        return $this->hasMany(ClientePlano::class);
    }
}