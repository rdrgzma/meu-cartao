<div
    class="py-6 space-y-6 border rounded-xl border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-sm"
    wire:cloak
    x-data="{ showRecoveryCodes: false }"
>
    <div class="px-6 space-y-2">
        <div class="flex items-center gap-2">
            <x-icons.shield-check class="w-5 h-5 text-zinc-500" />
            <h5 class="text-md font-bold text-zinc-900 dark:text-white">{{ __('Códigos de Recuperação 2FA') }}</h5>
        </div>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('Os códigos de recuperação permitem que você recupere o acesso caso perca seu dispositivo 2FA. Guarde-os em um gerenciador de senhas seguro.') }}
        </p>
    </div>

    <div class="px-6 pt-6 border-t border-zinc-100 dark:border-zinc-800">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <x-button
                x-show="!showRecoveryCodes"
                variant="zinc"
                @click="showRecoveryCodes = true;"
            >
                {{ __('Visualizar Códigos de Recuperação') }}
            </x-button>

            <x-button
                x-show="showRecoveryCodes"
                variant="zinc"
                @click="showRecoveryCodes = false"
            >
                {{ __('Ocultar Códigos') }}
            </x-button>

            @if (filled($recoveryCodes))
                <x-button
                    x-show="showRecoveryCodes"
                    variant="primary"
                    wire:click="regenerateRecoveryCodes"
                >
                    {{ __('Gerar Novos Códigos') }}
                </x-button>
            @endif
        </div>

        <div
            x-show="showRecoveryCodes"
            x-transition
            id="recovery-codes-section"
            class="relative overflow-hidden"
        >
            <div class="mt-4 space-y-4">
                @error('recoveryCodes')
                    <div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </div>
                @enderror

                @if (filled($recoveryCodes))
                    <div class="grid grid-cols-2 gap-4 p-4 font-mono text-sm rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                        @foreach($recoveryCodes as $code)
                            <div class="select-text text-zinc-900 dark:text-white font-bold" wire:loading.class="opacity-50 animate-pulse">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        {{ __('Cada código de recuperação pode ser usado uma única vez para acessar sua conta e será removido após o uso. Se precisar de mais, clique em Gerar novos códigos acima.') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
