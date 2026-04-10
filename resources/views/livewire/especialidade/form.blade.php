<x-modal name="especialidade-modal" :title="($especialidade ? 'Editar' : 'Nova') . ' Especialidade'">
    <form wire:submit="save" class="space-y-6">
        <x-field label="Nome" :error="$errors->first('nome')">
            <input type="text" wire:model="nome" placeholder="Ex: Cardiologia"
                class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
        </x-field>

        <div class="flex items-center justify-between p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50">
            <div>
                <h4 class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('Especialidade Ativa') }}</h4>
                <p class="text-xs text-zinc-500">{{ __('Define se pode ser vinculada a planos.') }}</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model="ativo" class="sr-only peer">
                <div class="w-11 h-6 bg-zinc-200 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-zinc-900 dark:peer-checked:bg-white"></div>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                Cancelar
            </x-button>
            @if(!$especialidade)
                <x-button type="button" variant="secondary" wire:click="save(true)">
                    Salvar e cadastrar nova
                </x-button>
            @endif
            <x-button type="submit" variant="primary">
                {{ $especialidade ? 'Salvar Alterações' : 'Cadastrar Especialidade' }}
            </x-button>
        </div>
    </form>
</x-modal>
