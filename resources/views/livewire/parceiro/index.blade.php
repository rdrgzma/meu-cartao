<div class="page-section" x-data="{ openModal: false }">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Parceiros') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Gerencie as unidades e parceiros credenciados na rede.') }}</p>
        </div>

        <div>
            <x-button variant="primary" icon="users" wire:click="create">
                {{ __('Novo Parceiro') }}
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
                        placeholder="Buscar por nome ou documento..." 
                        class="input pl-10"
                    >
                </div>
                
                <div class="w-full md:w-48">
                    <select 
                        wire:model.live="status" 
                        class="select"
                    >
                        <option value="">{{ __('Todos os Status') }}</option>
                        <option value="ativo">{{ __('Ativo') }}</option>
                        <option value="inativo">{{ __('Inativo') }}</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <input type="date" wire:model.live="dataInicio" class="input">
                    <input type="date" wire:model.live="dataFim" class="input">
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <x-table :paginate="$parceiros">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Parceiro') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Contato & Endereço') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Especialidades') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Organização') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                <th class="px-6 py-4 font-semibold text-right">{{ __('Ações') }}</th>
            </x-slot>

            @foreach ($parceiros as $parceiro)
                <tr wire:key="parceiro-{{ $parceiro->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $parceiro->nome_fantasia }}</span>
                            <span class="text-xs text-zinc-500 font-mono">{{ $parceiro->documento }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                        <div class="flex flex-col">
                            <span class="flex items-center gap-1">
                                {{ $parceiro->telefone }}
                            </span>
                            <span class="text-xs italic">{{ $parceiro->cidade }} - {{ $parceiro->estado }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <x-badge color="zinc">
                            {{ $parceiro->especialidades_count }} atend.
                        </x-badge>
                    </td>

                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400 text-sm">
                        {{ $parceiro->tenant?->nome ?? __('Sem Organização') }}
                    </td>

                    <td class="px-6 py-4">
                        <button wire:click="toggleStatus({{ $parceiro->id }})" class="focus:outline-none">
                            <x-badge :color="$parceiro->status === 'ativo' ? 'green' : 'red'">
                                {{ ucfirst($parceiro->status) }}
                            </x-badge>
                        </button>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2" x-data="{ open: false }">
                            <x-button variant="ghost" size="sm" wire:click="edit({{ $parceiro->id }})">
                                {{ __('Editar') }}
                            </x-button>
                            <x-button variant="ghost" size="sm" class="text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/10" 
                                wire:click="delete({{ $parceiro->id }})" 
                                wire:confirm="{{ __('Tem certeza?') }}"
                            >
                                {{ __('Excluir') }}
                            </x-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

    <livewire:parceiro.form />
</div>
