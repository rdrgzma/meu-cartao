<?php

namespace App\Services;

use App\Models\Parceiro;
use Illuminate\Pagination\LengthAwarePaginator;

class ParceiroService
{
    /**
     * Get paginated partners with advanced filters.
     */
    public function paginate(int $perPage = 10, ?string $search = null, ?string $status = null, ?string $dataInicio = null, ?string $dataFim = null): LengthAwarePaginator
    {
        return Parceiro::query()
            ->when($search, function ($q) use ($search) {
                $q->where(fn ($query) => $query->where('nome_fantasia', 'like', "%{$search}%")
                    ->orWhere('cnpj_cpf', 'like', "%{$search}%"));
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($dataInicio, fn ($q) => $q->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('created_at', '<=', $dataFim))
            ->withCount('especialidades')
            ->with('tenant')
            ->orderBy('nome_fantasia')
            ->paginate($perPage);
    }

    /**
     * Create a new partner.
     */
    public function create(array $data): Parceiro
    {
        return Parceiro::create($data);
    }

    /**
     * Update an existing partner.
     */
    public function update(Parceiro $parceiro, array $data): bool
    {
        return $parceiro->update($data);
    }

    /**
     * Delete a partner.
     */
    public function delete(Parceiro $parceiro): bool
    {
        return $parceiro->delete();
    }

    /**
     * Link specialties to partner.
     */
    public function vincularEspecialidades(Parceiro $parceiro, array $especialidades): void
    {
        $parceiro->especialidades()->sync($especialidades);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Parceiro $parceiro): bool
    {
        return $parceiro->update(['status' => $parceiro->status === 'ativo' ? 'inativo' : 'ativo']);
    }
}
