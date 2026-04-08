<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carencia extends Model
{
    use HasFactory;
    protected $fillable = ['plano_id','especialidade_id','dias'];

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
}