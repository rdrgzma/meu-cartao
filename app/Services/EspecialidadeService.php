<?php

namespace App\Services;

use App\Models\Especialidade;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EspecialidadeService
{
    /**
     * Get paginated specialties with advanced filters.
     */
    public function paginate(int $perPage = 10, ?string $search = null, ?string $status = null, ?string $dataInicio = null, ?string $dataFim = null): LengthAwarePaginator
    {
        return Especialidade::query()
            ->when($search, fn ($q) => $q->where('nome', 'like', "%{$search}%"))
            ->when($status, fn ($q) => $q->where('ativo', $status === '1'))
            ->when($dataInicio, fn ($q) => $q->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('created_at', '<=', $dataFim))
            ->with('tenant')
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Get all active specialties.
     */
    public function getActive(): Collection
    {
        return Especialidade::where('ativo', true)->orderBy('nome')->get();
    }

    /**
     * Create a new specialty.
     */
    public function create(array $data): Especialidade
    {
        return Especialidade::create($data);
    }

    /**
     * Update an existing specialty.
     */
    public function update(Especialidade $especialidade, array $data): bool
    {
        return $especialidade->update($data);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Especialidade $especialidade): bool
    {
        return $especialidade->update(['ativo' => ! $especialidade->ativo]);
    }

    /**
     * Delete a specialty.
     */
    public function delete(Especialidade $especialidade): bool
    {
        return $especialidade->delete();
    }
}
