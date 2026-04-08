<?phpnamespace App\Services;

use App\Models\Parceiro;

class ParceiroService
{
    public function vincularEspecialidades(Parceiro $parceiro, array $especialidades): void
    {
        $parceiro->especialidades()->sync($especialidades);
    }
}