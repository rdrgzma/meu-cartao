<div class="page-section" x-data="{ openModal: false }">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Clientes') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Gerencie os assinantes e dependentes do Cartão Mais Saúde.') }}</p>
        </div>

        @if(auth()->user()->funcao !== 'parceiro')
            <div>
                <x-button variant="primary" icon="users" wire:click="create">
                    {{ __('Novo Cliente') }}
                </x-button>
            </div>
        @endif
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
                        placeholder="Buscar por nome, CPF ou e-mail..." 
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
                        <option value="inadimplente">{{ __('Inadimplente') }}</option>
                        <option value="cancelado">{{ __('Cancelado') }}</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <input type="date" wire:model.live="dataInicio" class="input">
                    <input type="date" wire:model.live="dataFim" class="input">
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <x-table :paginate="$clientes">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Cliente') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Documentos') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Plano Atual') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Organização') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                <th class="px-6 py-4 font-semibold text-right">{{ __('Ações') }}</th>
            </x-slot>

            @foreach ($clientes as $cliente)
                <tr wire:key="cliente-{{ $cliente->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $cliente->nome }}</span>
                            <span class="text-xs text-zinc-500">{{ $cliente->email }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                        <div class="flex flex-col">
                            <span>CPF: {{ $cliente->cpf }}</span>
                            @if($cliente->cns)
                                <span class="text-xs">CNS: {{ $cliente->cns }}</span>
                            @endif
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        @if($cliente->plano)
                            <x-badge color="zinc">
                                {{ $cliente->plano->nome }}
                            </x-badge>
                        @else
                            <span class="text-zinc-400 italic">Sem plano</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                        {{ $cliente->tenant?->nome ?? __('Sem Organização') }}
                    </td>

                    <td class="px-6 py-4">
                        <x-badge :color="$cliente->status === 'ativo' ? 'green' : ($cliente->status === 'inadimplente' ? 'red' : 'zinc')">
                            {{ ucfirst($cliente->status) }}
                        </x-badge>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-1">
                            <x-button variant="ghost" size="sm" wire:click="abrirCarteira({{ $cliente->id }})">
                                {{ __('Carteira') }}
                            </x-button>
                            @if(auth()->user()->funcao !== 'parceiro')
                                <x-button variant="ghost" size="sm" wire:click="edit({{ $cliente->id }})">
                                    {{ __('Editar') }}
                                </x-button>
                                <x-button variant="ghost" size="sm" class="text-red-500 hover:text-red-700 hover:bg-red-50" wire:click="delete({{ $cliente->id }})" wire:confirm="{{ __('Excluir?') }}">
                                    {{ __('Excluir') }}
                                </x-button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

    <livewire:cliente.form />

    <x-modal name="carteira-modal" title="Carteira Digital">
        <livewire:cliente.carteira />
    </x-modal>
</div>
