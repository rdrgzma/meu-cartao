<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Histórico de Pagamentos') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Relatório detalhado de transações recebidas.') }}</p>
        </div>
        <div>
            {{-- Ações futuras, se necessário --}}
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="filter-bar">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.banknotes class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por cliente..."
                        class="input pl-10">
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <input type="date" wire:model.live="dataInicio" class="input">
                    <input type="date" wire:model.live="dataFim" class="input">
                </div>
            </div>
        </div>

        <x-table :paginate="$pagamentos">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Data') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Cliente') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Referência') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Método') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Valor') }}</th>
            </x-slot>

            @foreach ($pagamentos as $pagamento)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 text-zinc-500">{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 font-semibold text-zinc-900 dark:text-white">{{ $pagamento->mensalidade->cliente->nome ?? 'Excluído' }}</td>
                    <td class="px-6 py-4 text-zinc-500">{{ \Carbon\Carbon::parse($pagamento->mensalidade->mes_referencia)->format('m/Y') }}</td>
                    <td class="px-6 py-4 capitalize text-zinc-600 dark:text-zinc-400">{{ $pagamento->metodo ?? 'Dinheiro' }}</td>
                    <td class="px-6 py-4 text-green-600 dark:text-green-400 font-bold font-mono">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </x-table>
    </div>
</div>
