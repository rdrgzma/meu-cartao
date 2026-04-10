<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Consulta de Carência') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Verifique a elegibilidade do cliente por especialidade.') }}</p>
        </div>
        <div>
            {{-- Ações futuras --}}
        </div>
    </div>

    <div class="card-premium p-6">
        <div class="mb-6">
            <x-field label="Buscar Cliente">
                <div class="relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.users class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Busque cliente por Nome ou CPF..."
                        class="input pl-10">
                </div>
            </x-field>
        </div>

        @if ($cliente)
            <div class="mb-8 p-4 bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider">{{ __('Cliente Selecionado') }}</p>
                        <p class="text-xl font-bold text-zinc-900 dark:text-white">{{ $cliente->nome }}</p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Plano: <span class="font-medium">{{ $cliente->plano->nome ?? 'Sem plano' }}</span> |
                            Adesão: <span class="font-medium">{{ \Carbon\Carbon::parse($cliente->data_adesao)->format('d/m/Y') }}</span>
                        </p>
                    </div>
                    <x-badge :color="$cliente->status === 'ativo' ? 'green' : 'red'" class="text-sm px-3 py-1">
                        {{ ucfirst($cliente->status) }}
                    </x-badge>
                </div>
            </div>

            <x-table>
                <x-slot name="columns">
                    <th class="px-6 py-4 font-semibold">{{ __('Especialidade') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Cobertura') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Data Liberação') }}</th>
                    <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                </x-slot>

                @foreach ($especialidadesStatus as $item)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                        <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">{{ $item['nome'] }}</td>
                        <td class="px-6 py-4">
                            @if ($item['coberto'])
                                <span class="text-green-500 font-bold">✓ Coberto</span>
                            @else
                                <span class="text-red-500 font-bold">✗ Não coberto</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-zinc-500">{{ $item['data_liberacao'] }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColor = match($item['status']) {
                                    'liberado' => 'green',
                                    'em carência' => 'amber',
                                    default => 'red',
                                };
                            @endphp
                            <x-badge :color="$statusColor">{{ ucfirst($item['status']) }}</x-badge>
                        </td>
                    </tr>
                @endforeach
            </x-table>

        @elseif (strlen($search) >= 3)
            <div class="py-12 text-center text-zinc-500">
                {{ __('Nenhum cliente encontrado com') }} "{{ $search }}".
            </div>
        @else
            <div class="py-12 text-center text-zinc-400">
                <x-icons.users class="w-12 h-12 mx-auto mb-4 opacity-30" />
                <p>{{ __('Digite pelo menos 3 caracteres para buscar um cliente.') }}</p>
            </div>
        @endif
    </div>
</div>
