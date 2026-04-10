<?php

namespace App\Livewire\Dashboard;

use App\Services\RelatorioService;
use Livewire\Component;

class Stats extends Component
{
    public array $stats = [];

    public function mount(RelatorioService $service): void
    {
        $this->stats = $service->statsAdmin();
    }

    public function render()
    {
        return view('livewire.dashboard.stats');
    }
}
