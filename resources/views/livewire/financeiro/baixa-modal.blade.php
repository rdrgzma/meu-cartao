<x-modal name="baixa-modal" title="Registrar Pagamento">
    <div class="space-y-4 mb-6">
        <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800">
            <p class="text-xs text-zinc-500 uppercase font-bold tracking-wider mb-1">Cliente</p>
            <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $mensalidade?->cliente?->nome }}</p>
            <p class="text-xs text-zinc-500 mt-2">{{ __('Mensalidade ref. ao plano') }} {{ $mensalidade?->cliente?->plano?->nome }}</p>
        </div>
    </div>

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
