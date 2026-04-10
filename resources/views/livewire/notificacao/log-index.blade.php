<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Logs de Notificações') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Histórico completo de mensagens disparadas pelo sistema.') }}</p>
        </div>
        <div>
            {{-- Ações futuras --}}
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <x-table :paginate="$logs">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Data/Hora') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Cliente') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Tipo') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Conteúdo') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
            </x-slot>

            @foreach ($logs as $log)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">
                        {{ $log->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $log->cliente->nome ?? 'Excluído' }}</span>
                            <span class="text-xs text-zinc-500">{{ $log->cliente->telefone ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <x-badge color="zinc">{{ ucfirst(str_replace('_', ' ', $log->tipo)) }}</x-badge>
                    </td>
                    <td class="px-6 py-4 max-w-xs">
                        <span class="truncate block" title="{{ $log->conteudo }}">{{ $log->conteudo }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <x-badge :color="$log->status === 'enviado' ? 'green' : 'red'">{{ ucfirst($log->status) }}</x-badge>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</div>
