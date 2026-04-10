<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carencia extends Model
{
    use HasFactory, Tenantable;
    protected $fillable = ['tenant_id', 'plano_id','especialidade_id','dias'];

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
}