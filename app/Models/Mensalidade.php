<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensalidade extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id','valor','vencimento','status'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
}
