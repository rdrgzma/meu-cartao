<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use HasFactory, SoftDeletes, Tenantable;

    protected $fillable = ['tenant_id', 'nome', 'valor', 'descricao', 'ativo'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'plano_especialidades')
            ->withPivot('tipo_cobertura')
            ->withTimestamps();
    }

    public function carencias()
    {
        return $this->hasMany(Carencia::class);
    }
}
