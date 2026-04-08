<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory;
        protected $fillable = ['nome','slug'];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
