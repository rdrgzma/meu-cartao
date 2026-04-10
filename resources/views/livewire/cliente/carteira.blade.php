<div class="space-y-6">
    @if ($cliente)
        <!-- Header -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Sua Carteira Virtual') }}</h1>
            <p class="text-sm text-zinc-500">{{ __('Apresente este cartão no atendimento parceiro.') }}</p>
        </div>

        <!-- Cartão Virtual -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-900 text-white shadow-2xl p-6 min-h-[240px]">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <div class="text-[10px] uppercase font-bold tracking-[0.2em] opacity-70">Cartão de Benefícios</div>
                    <div class="text-lg font-bold">CMS Saúde</div>
                </div>
                <x-icons.shield-check class="w-8 h-8 opacity-50" />
            </div>

            <div class="space-y-4">
                <div class="text-xl font-medium tracking-wide uppercase">{{ $cliente->nome }}</div>
                <div class="flex justify-between items-end">
                    <div class="space-y-1">
                        <div class="text-[8px] uppercase tracking-wider opacity-60">Plano Atual</div>
                        <div class="font-bold text-sm">{{ $cliente->plano->nome ?? 'Nenhum' }}</div>
                    </div>
                    <div class="space-y-1 text-right">
                        <div class="text-[8px] uppercase tracking-wider opacity-60">Status</div>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-white/20 text-white border border-white/30">
                            {{ ucfirst($cliente->status) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <!-- QR Code -->
        <div class="card-premium flex flex-col items-center justify-center space-y-4 p-8">
            <div class="bg-white p-4 rounded-2xl shadow-inner border border-zinc-100">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($dadosCarteira['qr_code']) }}"
                    alt="QR Code de Validação" class="w-40 h-40">
            </div>
            <div class="text-center">
                <h3 class="font-bold text-zinc-900 dark:text-white">{{ __('Validar Atendimento') }}</h3>
                <p class="text-sm text-zinc-500 mt-1">Token: <code class="font-mono">{{ substr($dadosCarteira['qr_code'], -8) }}</code></p>
            </div>
        </div>

        <!-- Dados -->
        <div class="grid grid-cols-2 gap-4">
            <div class="card-premium p-4">
                <div class="text-xs text-zinc-500 mb-1">CPF</div>
                <div class="font-bold font-mono text-sm">{{ $cliente->cpf }}</div>
            </div>
            <div class="card-premium p-4">
                <div class="text-xs text-zinc-500 mb-1">CNS</div>
                <div class="font-bold font-mono text-sm">{{ $cliente->cns ?? '-' }}</div>
            </div>
        </div>

        <!-- Coberturas -->
        <div class="card-premium overflow-hidden">
            <div class="p-4 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="font-bold text-zinc-900 dark:text-white">{{ __('Coberturas do Plano') }}</h3>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($dadosCarteira['especialidades'] ?? [] as $esp)
                    <div class="p-4 flex flex-col gap-1">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $esp['nome'] }}</span>
                            @php 
                                $color = match($esp['status'] ?? 'nao_coberto') { 
                                    'liberado' => 'green', 
                                    'em_carencia' => 'amber', 
                                    default => 'red' 
                                }; 
                            @endphp
                            <x-badge :color="$color">
                                {{ ucfirst(str_replace('_', ' ', $esp['status'] ?? 'Nao Coberto')) }}
                            </x-badge>
                        </div>
                        
                        <div class="flex justify-between items-center text-[10px] text-zinc-500">
                            <span>Carência: {{ $esp['dias_carencia'] ?? 0 }} dias</span>
                            @if(($esp['status'] ?? '') === 'em_carencia' && ($esp['liberado_em'] ?? null))
                                <span class="text-amber-600 dark:text-amber-400 font-medium">Libera em: {{ \Carbon\Carbon::parse($esp['liberado_em'])->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-zinc-500 italic">
                        Nenhuma cobertura localizada para este plano.
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <x-icons.shield-check class="w-12 h-12 text-zinc-300 dark:text-zinc-600 mb-4" />
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ __('Cliente não localizado') }}</h3>
            <p class="text-sm text-zinc-500 mt-1">{{ __('Não foi possível encontrar uma carteira vinculada a este perfil.') }}</p>
        </div>
    @endif

    <div class="text-center py-6 text-xs text-zinc-400">
        Cartão Mais Saúde &bull; Versão 4.0
    </div>
</div>
