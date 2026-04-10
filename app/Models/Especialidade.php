<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidade extends Model
{
    use HasFactory, SoftDeletes, Tenantable;

    protected $fillable = ['nome', 'ativo'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function planos()
    {
        return $this->belongsToMany(Plano::class, 'plano_especialidades');
    }

    public function parceiros()
    {
        return $this->belongsToMany(Parceiro::class, 'parceiro_especialidades');
    }
}
