<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Financeiro') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Gestão de mensalidades, faturas e controle de inadimplência.') }}</p>
        </div>

        <div>
            <x-button variant="secondary" icon="home" wire:click="marcarAtrasos">
                {{ __('Verificar Atrasos') }}
            </x-button>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <!-- Filtros -->
        <div class="filter-bar">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.home class="w-5 h-5" />
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Buscar por cliente..." 
                        class="input pl-10"
                    >
                </div>
                
                <div class="w-full md:w-48">
                    <select 
                        wire:model.live="status" 
                        class="select"
                    >
                        <option value="">{{ __('Todos os Status') }}</option>
                        <option value="pago">{{ __('Pago') }}</option>
                        <option value="pendente">{{ __('Pendente') }}</option>
                        <option value="atrasado">{{ __('Atrasado') }}</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <input type="date" wire:model.live="dataInicio" class="input">
                    <input type="date" wire:model.live="dataFim" class="input">
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <x-table :paginate="$mensalidades">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Cliente') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Vencimento') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Valor') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Organização') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                <th class="px-6 py-4 font-semibold text-right">{{ __('Ações') }}</th>
            </x-slot>

            @foreach ($mensalidades as $mensalidade)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $mensalidade->cliente->nome }}</span>
                            <span class="text-xs text-zinc-500">{{ $mensalidade->cliente->plano->nome ?? 'Sem plano' }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($mensalidade->vencimento)->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4 font-mono font-medium">
                        R$ {{ number_format($mensalidade->valor, 2, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                        {{ $mensalidade->cliente->tenant?->nome ?? __('Sem Organização') }}
                    </td>

                    <td class="px-6 py-4">
                        <x-badge :color="$mensalidade->status === 'pago' ? 'green' : ($mensalidade->status === 'atrasado' ? 'red' : 'zinc')">
                            {{ ucfirst($mensalidade->status) }}
                        </x-badge>
                    </td>

                    <td class="px-6 py-4 text-right">
                        @if ($mensalidade->status !== 'pago')
                            <x-button 
                                variant="ghost" 
                                size="sm" 
                                icon="shield-check"
                                @click="$dispatch('open-modal', 'baixa-modal'); $dispatchTo('financeiro.baixa-modal', 'setMensalidade', { id: {{ $mensalidade->id }} })"
                            >
                                {{ __('Dar Baixa') }}
                            </x-button>
                        @else
                            <span class="text-green-500 text-xs font-semibold px-2 italic">{{ __('Liquidado') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

    <livewire:financeiro.baixa-modal />
</div>
