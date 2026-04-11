<x-modal name="baixa-modal" title="Registrar Pagamento">
    @if($mensalidade)
        <div class="mb-6 p-5 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800 space-y-4">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-300 font-bold">
                        {{ substr($mensalidade->cliente->nome, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-white">{{ $mensalidade->cliente->nome }}</h3>
                        <p class="text-[11px] text-zinc-500 font-mono tracking-tight">{{ $mensalidade->cliente->cpf }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] uppercase font-bold tracking-widest text-zinc-400 mb-1 block">Referência</span>
                    <x-badge color="zinc">
                        {{ \Carbon\Carbon::parse($mensalidade->vencimento)->translatedFormat('F/Y') }}
                    </x-badge>
                </div>
            </div>

            <div class="pt-4 border-t border-zinc-200/50 dark:border-zinc-700/50 grid grid-cols-2 gap-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-zinc-500 block mb-1">Plano Adquirido</span>
                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">{{ $mensalidade->cliente->plano->nome }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] uppercase font-bold tracking-widest text-zinc-500 block mb-1">Valor do Título</span>
                    <span class="text-sm font-bold text-zinc-900 dark:text-white">R$ {{ number_format($mensalidade->valor, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <x-field label="Valor Recebido (R$)" :error="$errors->first('valor_pago')">
                <input type="number" step="0.01" wire:model="valor_pago" placeholder="0.00" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>

            <x-field label="Data do Pagamento" :error="$errors->first('data_pagamento')">
                <input type="date" wire:model="data_pagamento" class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all">
            </x-field>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-zinc-100 dark:border-zinc-800">
            <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                Cancelar
            </x-button>
            <x-button type="submit" variant="primary">
                Confirmar Recebimento
            </x-button>
        </div>
    </form>
</x-modal>
