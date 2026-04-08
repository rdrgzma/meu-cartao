<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Tenantable;

class Especialidade extends Model
{
    use HasFactory, Tenantable;
    protected $fillable = ['nome','ativo'];

    public function planos()
    {
        return $this->belongsToMany(Plano::class, 'plano_especialidades');
    }

    public function parceiros()
    {
        return $this->belongsToMany(Parceiro::class, 'parceiro_especialidades');
    }
}