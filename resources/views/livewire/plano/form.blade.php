<x-modal name="plano-modal" :title="($plano ? 'Editar' : 'Novo') . ' Plano'">
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Nome do Plano" :error="$errors->first('nome')">
                <input type="text" wire:model="nome" placeholder="Ex: Essencial" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="Valor Mensal (R$)" :error="$errors->first('valor')">
                <input type="number" step="0.01" wire:model="valor" placeholder="0.00" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="flex items-center justify-between p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50">
            <div>
                <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Plano Ativo</h4>
                <p class="text-xs text-zinc-500">Define se o plano pode ser vendido a novos clientes.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model="ativo" class="sr-only peer">
                <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-white"></div>
            </label>
        </div>

        <div class="h-px bg-zinc-100 dark:bg-zinc-800"></div>

        <div>
            <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-1">Coberturas e Carências</h4>
            <p class="text-xs text-zinc-500 mb-4">Selecione as especialidades e defina a carência (em dias).</p>
            
            <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                @foreach ($especialidades as $esp)
                    <div class="flex items-center justify-between p-3 border border-zinc-100 dark:border-zinc-800 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="selectedEspecialidades" value="{{ $esp->id }}" class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                            <span class="text-sm font-medium">{{ $esp->nome }}</span>
                        </label>

                        @if (in_array((string)$esp->id, $selectedEspecialidades))
                            <div class="w-24">
                                <input 
                                    type="number" 
                                    wire:model="carencias.{{ $esp->id }}" 
                                    placeholder="Dias" 
                                    class="w-full px-2 py-1 text-xs rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 outline-none focus:ring-1 focus:ring-zinc-900"
                                >
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-zinc-100 dark:border-zinc-800">
            <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                Cancelar
            </x-button>
            @if(!$plano)
                <x-button type="button" variant="secondary" wire:click="save(true)">
                    Salvar e cadastrar novo
                </x-button>
            @endif
            <x-button type="submit" variant="primary">
                {{ $plano ? 'Salvar Alterações' : 'Cadastrar Plano' }}
            </x-button>
        </div>
    </form>
</x-modal>
