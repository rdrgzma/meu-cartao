<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory, SoftDeletes;
        protected $fillable = ['nome','slug','documento','telefone','endereco','cidade','estado', 'status'];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
    public function planos()
    {
        return $this->hasMany(Plano::class);
    }
    public function especialidades()
    {
        return $this->hasMany(Especialidade::class);
    }
    public function parceiros()
    {
        return $this->hasMany(Parceiro::class);
    }
}
