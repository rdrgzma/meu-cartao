<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Especialidades') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Gerencie as especialidades médicas cobertas pelos planos.') }}</p>
        </div>
        <div>
            <x-button variant="primary" icon="academic-cap" wire:click="create">
                {{ __('Nova Especialidade') }}
            </x-button>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="filter-bar">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.academic-cap class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar especialidade..."
                        class="input pl-10">
                </div>
                <div class="w-full md:w-48">
                    <select wire:model.live="status" class="select">
                        <option value="">{{ __('Todos') }}</option>
                        <option value="1">{{ __('Ativos') }}</option>
                        <option value="0">{{ __('Inativos') }}</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <input type="date" wire:model.live="dataInicio" class="input">
                    <input type="date" wire:model.live="dataFim" class="input">
                </div>
            </div>
        </div>

        <x-table :paginate="$especialidades">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Nome') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                <th class="px-6 py-4 font-semibold text-right">{{ __('Ações') }}</th>
            </x-slot>

            @foreach ($especialidades as $especialidade)
                <tr wire:key="especialidade-{{ $especialidade->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 font-semibold text-zinc-900 dark:text-white">{{ $especialidade->nome }}</td>
                    <td class="px-6 py-4">
                        <button wire:click="toggleStatus({{ $especialidade->id }})" class="focus:outline-none">
                            <x-badge :color="$especialidade->ativo ? 'green' : 'red'">
                                {{ $especialidade->ativo ? 'Ativo' : 'Inativo' }}
                            </x-badge>
                        </button>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-1">
                            <x-button variant="ghost" size="sm" wire:click="edit({{ $especialidade->id }})">
                                {{ __('Editar') }}
                            </x-button>
                            <x-button variant="ghost" size="sm" class="text-red-500 hover:text-red-700"
                                wire:click="delete({{ $especialidade->id }})" wire:confirm="{{ __('Tem certeza?') }}">
                                {{ __('Excluir') }}
                            </x-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

    <livewire:especialidade.form />
</div>
