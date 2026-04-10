<x-modal name="user-modal" :title="$user ? __('Gerenciar Usuário') : __('Novo Usuário')">
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Nome" readonly>
                <input type="text" wire:model="name" class="input bg-zinc-50 dark:bg-zinc-800/50" readonly>
            </x-field>
            <x-field label="E-mail" readonly>
                <input type="email" wire:model="email" class="input bg-zinc-50 dark:bg-zinc-800/50" readonly>
            </x-field>
        </div>

        <x-field label="Nível de Acesso">
            <select wire:model.live="funcao" class="select">
                <option value="sistema">{{ __('Sistema (Global)') }}</option>
                <option value="admin">{{ __('Administrador (Unidade)') }}</option>
                <option value="parceiro">{{ __('Parceiro (Prestador)') }}</option>
                <option value="usuario">{{ __('Cliente/Usuário') }}</option>
            </select>
        </x-field>

        @if($funcao === 'parceiro')
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400">{{ __('Permissões do Parceiro') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <input type="checkbox" wire:model="can_access_dashboard" class="checkbox">
                        <span class="text-sm font-medium">{{ __('Dashboard') }}</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <input type="checkbox" wire:model="can_access_financeiro" class="checkbox">
                        <span class="text-sm font-medium">{{ __('Financeiro') }}</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <input type="checkbox" wire:model="can_access_relatorios" class="checkbox">
                        <span class="text-sm font-medium">{{ __('Relatórios & Logs') }}</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <input type="checkbox" wire:model="can_access_planos" class="checkbox">
                        <span class="text-sm font-medium">{{ __('Planos') }}</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <input type="checkbox" wire:model="can_access_especialidades" class="checkbox">
                        <span class="text-sm font-medium">{{ __('Especialidades') }}</span>
                    </label>
                </div>
            </div>
        @endif

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                {{ __('Cancelar') }}
            </x-button>
            <x-button type="submit" variant="primary">
                {{ __('Salvar Alterações') }}
            </x-button>
        </div>
    </form>
</x-modal>
