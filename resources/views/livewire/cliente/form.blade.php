<x-modal name="cliente-modal" :title="($cliente ? 'Editar' : 'Novo') . ' Cliente'">
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Nome Completo" :error="$errors->first('nome')">
                <input type="text" wire:model="nome" placeholder="Ex: João Silva" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="E-mail" :error="$errors->first('email')">
                <input type="email" wire:model="email" placeholder="joao@email.com" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="CPF" :error="$errors->first('cpf')">
                <input type="text" wire:model="cpf" placeholder="000.000.000-00" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="CNS (Opcional)" :error="$errors->first('cns')">
                <input type="text" wire:model="cns" placeholder="000.0000.0000.0000" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Telefone" :error="$errors->first('telefone')">
                <input type="text" wire:model="telefone" placeholder="(00) 00000-0000" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="Data de Adesão" :error="$errors->first('data_adesao')">
                <input type="date" wire:model="data_adesao" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Plano" :error="$errors->first('plano_id')">
                <select wire:model="plano_id" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
                    <option value="">Selecione um plano</option>
                    @foreach ($planos as $plano)
                        <option value="{{ $plano->id }}">{{ $plano->nome }} (R$ {{ number_format($plano->valor, 2, ',', '.') }})</option>
                    @endforeach
                </select>
            </x-field>

            <x-field label="Status">
                <select wire:model="status" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
                    <option value="ativo">Ativo</option>
                    <option value="inadimplente">Inadimplente</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </x-field>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-zinc-100 dark:border-zinc-800">
            <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                Cancelar
            </x-button>
            @if(!$cliente)
                <x-button type="button" variant="secondary" wire:click="save(true)">
                    Salvar e cadastrar novo
                </x-button>
            @endif
            <x-button type="submit" variant="primary">
                {{ $cliente ? 'Salvar Alterações' : 'Cadastrar Cliente' }}
            </x-button>
        </div>
    </form>
</x-modal>
