<div class="page-section max-w-2xl mx-auto" x-data="{}">
    <div class="page-header justify-center text-center border-none">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Validação de Cliente') }}</h1>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Consulte a elegibilidade para atendimento imediato.') }}</p>
        </div>
    </div>

    <div class="card-premium p-6 space-y-6">
        <x-field label="Identificação do Cliente">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Digite CPF ou Número da Carteira"
                class="input text-base py-3">
        </x-field>

        @if ($cliente)
            <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-lg font-bold">
                        {{ mb_strtoupper(substr($cliente->nome, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-lg text-zinc-900 dark:text-white">{{ $cliente->nome }}</div>
                        <div class="text-sm text-zinc-500 flex items-center gap-2">
                            Status Financeiro:
                            <x-badge :color="$cliente->status === 'ativo' ? 'green' : 'red'">
                                {{ ucfirst($cliente->status) }}
                            </x-badge>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                <x-field label="Especialidade para atendimento">
                    <select wire:model="selectedEspecialidadeId" class="select">
                        <option value="">Selecione a especialidade...</option>
                        @foreach ($especialidades as $esp)
                            <option value="{{ $esp->id }}">{{ $esp->nome }}</option>
                        @endforeach
                    </select>
                </x-field>

                <x-button variant="primary" class="w-full h-12 text-base" wire:click="validar">
                    <x-icons.shield-check class="w-5 h-5" />
                    {{ __('Validar Elegibilidade') }}
                </x-button>
            </div>
        @elseif (strlen($search) >= 3)
            <div class="py-8 text-center text-red-500 font-medium bg-red-50 dark:bg-red-950/20 rounded-lg">
                {{ __('Cliente não encontrado. Verifique o documento.') }}
            </div>
        @endif
    </div>

    @if ($resultado)
        @php
            $isLiberado = $resultado['status'] === 'liberado';
            $isCarencia = $resultado['status'] === 'em_carencia';
            $borderColor = $isLiberado ? 'border-green-500' : ($isCarencia ? 'border-yellow-500' : 'border-red-500');
            $bgColor = $isLiberado ? 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400' : ($isCarencia ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400' : 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400');
        @endphp
        <div class="card-premium p-6 border-t-4 {{ $borderColor }}">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-full {{ $bgColor }}">
                    <x-icons.shield-check class="w-6 h-6" />
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                        @if ($isLiberado) {{ __('Atendimento Liberado!') }}
                        @elseif ($isCarencia) {{ __('Aguardando Carência') }}
                        @elseif ($resultado['status'] === 'inadimplente') {{ __('Cliente Bloqueado') }}
                        @else {{ __('Não Coberto pelo Plano') }}
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        @if ($isLiberado) {{ __('O cliente possui cobertura completa para esta especialidade.') }}
                        @elseif ($isCarencia) {{ __('O período de carência encerra em:') }} <strong>{{ \Carbon\Carbon::parse($resultado['liberado_em'])->format('d/m/Y') }}</strong>
                        @elseif ($resultado['status'] === 'inadimplente') {{ __('Existem pendências financeiras. Direcione o cliente para o suporte.') }}
                        @else {{ __('Esta especialidade não está incluída no plano atual do cliente.') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
