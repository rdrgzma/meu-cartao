<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Configuração de Notificações') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Personalize as mensagens automáticas enviadas via WhatsApp.') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative w-64">
                <input type="text" wire:model.live="search" class="input pl-10 h-10" placeholder="Filtrar por nome ou organização...">
                <div class="absolute left-3 top-2.5 text-zinc-400">
                    <x-icons.list-bullet class="w-5 h-5" />
                </div>
            </div>
            <x-button variant="primary" icon="plus" wire:click="openCreateModal">
                {{ __('Nova Notificação') }}
            </x-button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @foreach ($templates as $index => $template)
            <div class="card-premium p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-zinc-900 dark:text-white">{{ $template['assunto'] }}</h3>
                            @if(isset($template['tenant']['nome']))
                                <span class="badge badge-zinc text-[10px]">{{ $template['tenant']['nome'] }}</span>
                            @endif
                        </div>
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

                <div class="flex justify-end gap-2">
                    @if (! in_array($template['tipo'], ['lembrete_pagamento', 'aviso_atraso', 'confirmacao_pagamento']))
                        <x-button variant="danger" size="sm" icon="trash" wire:click="delete({{ $template['id'] }})" wire:confirm="Tem certeza?">
                            {{ __('Excluir') }}
                        </x-button>
                    @endif
                    <x-button variant="primary" size="sm" wire:click="save({{ $index }})">
                        {{ __('Salvar Template') }}
                    </x-button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal de Criação -->
    @if($showingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-zinc-200 dark:border-zinc-800 animate-in fade-in zoom-in duration-200">
            <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <h3 class="text-lg font-bold">{{ __('Criar Notificação Personalizada') }}</h3>
                <button wire:click="$set('showingModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <x-icons.home class="w-5 h-5" /> {{-- Usando um icon genérico ou apenas o X --}}
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <x-field label="Tipo (Slug)">
                        <input type="text" wire:model="newTipo" class="input" placeholder="ex: aviso_vencimento_proximo">
                    </x-field>
                    <x-field label="Assunto">
                        <input type="text" wire:model="newAssunto" class="input" placeholder="ex: Vencimento em 5 dias">
                    </x-field>
                </div>

                <x-field label="Mensagem">
                    <textarea wire:model="newTemplate" rows="5" class="input font-mono" placeholder="Olá @{{nome}}, ..."></textarea>
                </x-field>

                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg text-[10px] text-zinc-500">
                    {{ __('Variáveis suportadas:') }} @{{nome}}, @{{valor}}, @{{vencimento}}, @{{cpf}}, @{{link_carteira}}
                </div>
            </div>

            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/30 flex justify-end gap-3">
                <x-button variant="secondary" wire:click="$set('showingModal', false)">{{ __('Cancelar') }}</x-button>
                <x-button variant="primary" wire:click="createNotification">{{ __('Criar Notificação') }}</x-button>
            </div>
        </div>
    </div>
    @endif
</div>
