<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Tenantable;

class Parceiro extends Model
{
    use HasFactory, SoftDeletes, Tenantable;
    protected $fillable = [
        'tenant_id','nome_fantasia','razao_social','documento',
        'telefone','endereco','cidade','estado','status'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'parceiro_especialidades');
    }
}
