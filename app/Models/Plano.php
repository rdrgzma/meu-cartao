<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Tenantable;

class Plano extends Model
{
    use HasFactory, Tenantable;
    protected $fillable = ['tenant_id','nome','valor','descricao','ativo'];

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