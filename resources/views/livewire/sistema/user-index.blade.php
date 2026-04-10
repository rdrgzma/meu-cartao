<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Usuários do Sistema') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Gerencie as contas de acesso e níveis de permissão.') }}</p>
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
                        <x-icons.users class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome ou e-mail..."
                        class="input pl-10">
                </div>
                <div class="w-full md:w-32">
                    <select wire:model.live="status" class="select">
                        <option value="">{{ __('Status') }}</option>
                        <option value="ativo">{{ __('Ativo') }}</option>
                        <option value="inativo">{{ __('Inativo') }}</option>
                    </select>
                </div>
                <div class="w-full md:w-48">
                    <select wire:model.live="tipo" class="select">
                        <option value="">{{ __('Tipo de Acesso') }}</option>
                        <option value="admin">{{ __('Administrador') }}</option>
                        <option value="usuario">{{ __('Usuário Comum') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <x-table :paginate="$users">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold">{{ __('Nome') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('E-mail') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Tipo') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Criação') }}</th>
            </x-slot>

            @foreach ($users as $user)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 font-semibold text-zinc-900 dark:text-white">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $user->email }}</td>
                    <td class="px-6 py-4"><x-badge color="zinc">{{ ucfirst($user->tipo) }}</x-badge></td>
                    <td class="px-6 py-4">
                        <x-badge :color="$user->status === 'ativo' ? 'green' : 'red'">{{ ucfirst($user->status) }}</x-badge>
                    </td>
                    <td class="px-6 py-4 text-zinc-500">{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </x-table>
    </div>
</div>
