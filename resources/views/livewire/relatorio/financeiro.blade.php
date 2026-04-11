<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Relatório Financeiro') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Analise o faturamento e recebimentos por período.') }}</p>
        </div>
        <div>
            <x-button variant="secondary" icon="document-text" wire:click="exportCsv">
                {{ __('Exportar CSV') }}
            </x-button>
        </div>
    </div>

    <div class="card-premium p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-field label="Data Início">
                <input type="date" wire:model.live="dataInicio" class="input">
            </x-field>
            <x-field label="Data Fim">
                <input type="date" wire:model.live="dataFim" class="input">
            </x-field>
            <x-field label="Status">
                <select wire:model.live="status" class="select">
                    <option value="">{{ __('Todos') }}</option>
                    <option value="pago">{{ __('Pago') }}</option>
                    <option value="pendente">{{ __('Pendente') }}</option>
                    <option value="atrasado">{{ __('Atrasado') }}</option>
                </select>
            </x-field>
        </div>

        <div class="h-px bg-zinc-100 dark:bg-zinc-800"></div>

        <div>
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-4">{{ __('Resumo do Período') }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-5 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-100 dark:border-green-900/30">
                    <p class="text-xs text-green-600 dark:text-green-400 font-semibold">{{ __('Total Recebido') }}</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300 mt-1">
                        R$ {{ number_format($totalRecebido, 2, ',', '.') }}
                    </p>
                </div>
                <div class="p-5 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-900/30">
                    <p class="text-xs text-red-600 dark:text-red-400 font-semibold">{{ __('Total Pendente/Atrasado') }}</p>
                    <p class="text-2xl font-bold text-red-700 dark:text-red-300 mt-1">
                        R$ {{ number_format($totalPendente, 2, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <x-table :paginate="$vendas">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Data Pagamento') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Unidade') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Cliente') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Referência') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Valor Pago') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
            </x-slot>

            @foreach ($vendas as $venda)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 text-zinc-500">{{ $venda->data_pagamento ? \Carbon\Carbon::parse($venda->data_pagamento)->format('d/m/Y') : '-' }}</td>
                    <td class="px-6 py-4 text-zinc-500">{{ $venda->tenant->nome ?? '-' }}</td>
                    <td class="px-6 py-4 font-semibold text-zinc-900 dark:text-white">{{ $venda->cliente->nome ?? 'Excluído' }}</td>
                    <td class="px-6 py-4 text-zinc-500">{{ \Carbon\Carbon::parse($venda->vencimento)->format('m/Y') }}</td>
                    <td class="px-6 py-4 font-bold font-mono">R$ {{ number_format($venda->valor_pago, 2, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php $color = match($venda->status) { 'pago' => 'green', 'atrasado' => 'red', default => 'zinc' }; @endphp
                        <x-badge :color="$color">{{ ucfirst($venda->status) }}</x-badge>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</div>
