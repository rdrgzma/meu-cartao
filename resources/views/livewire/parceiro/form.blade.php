<x-modal name="parceiro-modal" :title="($parceiro ? 'Editar' : 'Novo') . ' Parceiro'">
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Nome Fantasia" :error="$errors->first('nome_fantasia')">
                <input type="text" wire:model="nome_fantasia" placeholder="Ex: Clínica Saúde" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="Razão Social" :error="$errors->first('razao_social')">
                <input type="text" wire:model="razao_social" placeholder="Ex: Clínica Saúde Ltda" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="CNPJ/CPF" :error="$errors->first('documento')">
                <input type="text" wire:model="documento" placeholder="00.000.000/0000-00" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="Telefone" :error="$errors->first('telefone')">
                <input type="text" wire:model="telefone" placeholder="(00) 00000-0000" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="h-px bg-zinc-100 dark:bg-zinc-800"></div>

        <x-field label="Endereço Completo" :error="$errors->first('endereco')">
            <input type="text" wire:model="endereco" placeholder="Rua, Número, Bairro..." class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
        </x-field>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Cidade" :error="$errors->first('cidade')">
                <input type="text" wire:model="cidade" placeholder="São Paulo" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
            <div class="grid grid-cols-2 gap-4">
                <x-field label="Estado" :error="$errors->first('estado')">
                    <input type="text" wire:model="estado" placeholder="SP" maxlength="2" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
                </x-field>
                <x-field label="Status">
                    <select wire:model="status" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </x-field>
            </div>
        </div>

        <div class="h-px bg-zinc-100 dark:bg-zinc-800"></div>

        <div>
            <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Especialidades Atendidas</h4>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 max-h-[150px] overflow-y-auto pr-2 custom-scrollbar">
                @foreach ($especialidades as $esp)
                    <label class="flex items-center gap-2 p-2 rounded hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors cursor-pointer">
                        <input type="checkbox" wire:model="selectedEspecialidades" value="{{ $esp->id }}" class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                        <span class="text-sm">{{ $esp->nome }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                Cancelar
            </x-button>
            @if(!$parceiro)
                <x-button type="button" variant="secondary" wire:click="save(true)">
                    Salvar e cadastrar novo
                </x-button>
            @endif
            <x-button type="submit" variant="primary">
                {{ $parceiro ? 'Salvar Alterações' : 'Cadastrar Unidade' }}
            </x-button>
        </div>
    </form>
</x-modal>
