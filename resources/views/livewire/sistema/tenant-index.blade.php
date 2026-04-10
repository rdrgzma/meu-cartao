<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Organizações (Unidades)') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Gestão de licenciados e unidades do Cartão Mais Saúde.') }}</p>
        </div>
        <div>
            {{-- Ações futuras --}}
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="filter-bar">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.building-library class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome ou documento..."
                        class="input pl-10">
                </div>
                <div class="w-full md:w-64 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.home class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="cidade" placeholder="Filtrar por cidade..."
                        class="input pl-10">
                </div>
            </div>
        </div>

        <x-table :paginate="$tenants">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Nome') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Documento') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Cidade/UF') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Telefone') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Criação') }}</th>
            </x-slot>

            @foreach ($tenants as $tenant)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 font-semibold text-zinc-900 dark:text-white">{{ $tenant->nome }}</td>
                    <td class="px-6 py-4 text-zinc-500 font-mono">{{ $tenant->documento }}</td>
                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $tenant->cidade }} / {{ $tenant->estado }}</td>
                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $tenant->telefone }}</td>
                    <td class="px-6 py-4 text-zinc-500">{{ $tenant->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </x-table>
    </div>
</div>
