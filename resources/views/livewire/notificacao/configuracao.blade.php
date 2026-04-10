<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Configuração de Notificações') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Personalize as mensagens automáticas enviadas via WhatsApp.') }}</p>
        </div>
        <div>
            {{-- Ações adicionais --}}
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @foreach ($templates as $index => $template)
            <div class="card-premium p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-zinc-900 dark:text-white">{{ $template['assunto'] }}</h3>
                        <p class="text-xs uppercase font-bold text-zinc-400 mt-1">Tipo: {{ $template['tipo'] }}</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="templates.{{ $index }}.ativo" class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-200 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-zinc-900 dark:peer-checked:bg-white"></div>
                        <span class="ml-2 text-sm font-medium">{{ __('Ativo') }}</span>
                    </label>
                </div>

                <x-field label="Template da Mensagem">
                    <textarea wire:model="templates.{{ $index }}.template" rows="3"
                        class="input resize-none font-mono"></textarea>
                    <p class="text-xs text-zinc-400 mt-1">Variáveis: <code>@{{nome}}</code>, <code>@{{cpf}}</code>, <code>@{{valor}}</code>, <code>@{{vencimento}}</code>, <code>@{{dias_atraso}}</code></p>
                </x-field>

                <div class="flex justify-end">
                    <x-button variant="primary" size="sm" wire:click="save({{ $index }})">
                        {{ __('Salvar Template') }}
                    </x-button>
                </div>
            </div>
        @endforeach
    </div>
</div>
