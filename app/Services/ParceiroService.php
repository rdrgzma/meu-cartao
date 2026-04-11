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
        $parceiro = Parceiro::create($data);
        if ($parceiro) {
            LogService::registrar(
                'Parceiros',
                'Novo Parceiro',
                "Parceiro {$parceiro->nome_fantasia} cadastrado.",
                ['parceiro_id' => $parceiro->id]
            );
        }

        return $parceiro;
    }

    /**
     * Update an existing partner.
     */
    public function update(Parceiro $parceiro, array $data): bool
    {
        $sucesso = $parceiro->update($data);
        if ($sucesso) {
            LogService::registrar(
                'Parceiros',
                'Atualização de Cadastro',
                "Dados do parceiro {$parceiro->nome_fantasia} foram atualizados.",
                ['parceiro_id' => $parceiro->id]
            );
        }

        return $sucesso;
    }

    /**
     * Delete a partner.
     */
    public function delete(Parceiro $parceiro): bool
    {
        $nome = $parceiro->nome_fantasia;
        $id = $parceiro->id;
        $sucesso = $parceiro->delete();
        if ($sucesso) {
            LogService::registrar(
                'Parceiros',
                'Exclusão de Parceiro',
                "Parceiro {$nome} (ID: {$id}) foi removido do sistema.",
                ['parceiro_id' => $id]
            );
        }

        return $sucesso;
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
        $sucesso = $parceiro->update(['status' => $parceiro->status === 'ativo' ? 'inativo' : 'ativo']);
        if ($sucesso) {

            LogService::registrar(
                'Parceiros',
                'Atualização de Status do Parceiro',
                "Status do parceiro {$parceiro->nome_fantasia} atualizado para {$parceiro->status}",
                ['parceiro_id' => $parceiro->id, 'status' => $parceiro->status]
            );
        }

        return $sucesso;
    }
}
