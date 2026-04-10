<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use App\Services\VirtualCardService;
use Livewire\Component;
use Livewire\Attributes\On;

class Carteira extends Component
{
    public ?Cliente $cliente = null;
    public array $dadosCarteira = [];

    #[On('show-carteira')]
    public function show(int $id): void
    {
        $this->cliente = Cliente::with(['plano.especialidades', 'tenant'])->findOrFail($id);
        $this->loadCarteira();
    }

    public function loadCarteira(): void
    {
        if (!$this->cliente) return;
        
        $service = app(VirtualCardService::class);
        $this->dadosCarteira = $service->gerarCarteira($this->cliente);
    }

    public function render()
    {
        return view('livewire.cliente.carteira');
    }
}
