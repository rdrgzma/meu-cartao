<?php

namespace App\Services;

use App\Models\Plano;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlanoService
{
    /**
     * Get paginated plans with advanced filters.
     */
    public function paginate(int $perPage = 10, ?string $search = null, ?string $status = null, ?string $dataInicio = null, ?string $dataFim = null): LengthAwarePaginator
    {
        return Plano::query()
            ->when($search, fn ($q) => $q->where('nome', 'like', "%{$search}%"))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($dataInicio, fn ($q) => $q->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn ($q) => $q->whereDate('created_at', '<=', $dataFim))
            ->withCount('especialidades')
            ->with('tenant')
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Get all active plans.
     */
    public function getActive(): Collection
    {
        return Plano::where('ativo', true)->orderBy('nome')->get();
    }

    /**
     * Create a new plan with relationships.
     */
    public function criar(array $data, array $especialidades = [], array $carencias = []): Plano
    {
        $plano = DB::transaction(function () use ($data, $especialidades, $carencias) {
            $plano = Plano::create($data);

            if (! empty($especialidades)) {
                $this->syncRelationships($plano, $especialidades, $carencias);
            }

            return $plano;
        });
        if ($plano) {
            LogService::registrar(
                'Planos',
                'Novo Plano',
                "Plano {$plano->nome} cadastrado no valor de R$ ".number_format($plano->valor, 2, ',', '.'),
                [
                    'plano_id' => $plano->id,
                    'valor' => $plano->valor,
                    'especialidades' => $especialidades,
                    'carencias' => $carencias,
                ]
            );
        }

        return $plano;

    }

    /**
     * Update an existing plan with relationships.
     */
    public function update(Plano $plano, array $data, array $especialidades = [], array $carencias = []): bool
    {
        $valorAntigo = $plano->valor;

        return DB::transaction(function () use ($plano, $data, $especialidades, $carencias, $valorAntigo) {
            $updated = $plano->update($data);

            $this->syncRelationships($plano, $especialidades, $carencias);
            if ($updated) {
                LogService::registrar(
                    'Planos',
                    'Atualização de Plano',
                    "Plano {$plano->nome} atualizado.",
                    [
                        'plano_id' => $plano->id,
                        'valor_novo' => $plano->valor,
                        'valor_antigo' => $valorAntigo,
                        'especialidades' => $especialidades,
                        'carencias' => $carencias,
                    ]
                );
            }

            return $updated;
        });
    }

    /**
     * Sync specialties and carencias.
     */
    protected function syncRelationships(Plano $plano, array $especialidades, array $carencias): void
    {
        // Sincroniza especialidades
        $syncData = [];
        foreach ($especialidades as $espId) {
            $syncData[$espId] = ['tipo_cobertura' => 'total'];
        }
        $plano->especialidades()->sync($syncData);

        // Sincroniza carências
        // Primeiro remove carências de especialidades que foram desmarcadas
        $plano->carencias()->whereNotIn('especialidade_id', $especialidades)->delete();

        // Atualiza ou cria as novas carências
        foreach ($carencias as $especialidadeId => $dias) {
            if (in_array((string) $especialidadeId, $especialidades)) {
                $plano->carencias()->updateOrCreate(
                    ['especialidade_id' => $especialidadeId],
                    ['dias' => $dias ?? 0]
                );
            }
        }
    }

    /**
     * Delete a plan.
     */
    public function delete(Plano $plano): bool
    {
        $sucesso = $plano->delete();
        if ($sucesso) {
            LogService::registrar(
                'Planos',
                'Exclusão de Plano',
                "Plano {$plano->nome} excluído.",
                ['plano_id' => $plano->id]
            );
        }

        return $sucesso;
    }
}
