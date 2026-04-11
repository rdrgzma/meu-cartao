<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtividadeLog extends Model
{
    use HasFactory, Tenantable;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'modulo',
        'acao',
        'descricao',
        'dados',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'dados' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Tenta resolver um ID para um nome amigável para exibição no log.
     */
    public function resolveLabel(string $key, $value): mixed
    {
        // Se for um array de IDs (comum em planos)
        if (is_array($value)) {
            return collect($value)->map(function ($id) use ($key) {
                if (! is_numeric($id)) {
                    return $id;
                }

                // Remove o plural ou tenta deduzir o tipo do ID no array
                $type = str_contains($key, 'especialidade') ? 'especialidade_id' : $key;

                return $this->resolveSingle($type, $id) ?? $id;
            })->toArray();
        }

        return $this->resolveSingle($key, $value);
    }

    private function resolveSingle(string $key, $value): ?string
    {
        if (! is_numeric($value)) {
            return null;
        }

        return match ($key) {
            'cliente_id' => Cliente::find($value)?->nome,
            'plano_id', 'novo_plano_id' => Plano::find($value)?->nome,
            'especialidade_id', 'especialidades' => Especialidade::find($value)?->nome,
            'user_id' => User::find($value)?->name,
            'tenant_id' => ($t = Tenant::find($value)) ? "{$t->nome} (ID: #{$t->id} | Doc: " . ($t->documento ?? 'N/A') . ")" : null,
            default => null,
        };
    }
}
