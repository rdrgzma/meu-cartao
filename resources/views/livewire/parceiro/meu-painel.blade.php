<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Meu Painel') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Resumo de especialidades e atendimentos realizados.') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <input type="date" wire:model.live="dataInicio" class="input h-10">
            <input type="date" wire:model.live="dataFim" class="input h-10">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Stats --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="card-premium p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl">
                        <x-icons.shield-check class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-xs font-bold text-zinc-400 uppercase tracking-widest">{{ __('Atendimentos (Mês)') }}</p>
                        <h3 class="text-3xl font-black text-zinc-900 dark:text-white">{{ $totalPeriodo }}</h3>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <h3 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-4">{{ __('Minhas Especialidades') }}</h3>
                <div class="space-y-2">
                    @forelse($especialidades as $espec)
                        <div class="flex items-center gap-2 p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                            <span class="text-sm font-medium">{{ $espec->nome }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-zinc-500 italic">{{ __('Nenhuma especialidade vinculada.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="lg:col-span-2">
            <div class="card-premium p-6 h-full">
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-6">{{ __('Detalhamento por Especialidade') }}</h3>
                
                <div class="space-y-4">
                    @forelse($atendimentos as $item)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-zinc-100 dark:border-zinc-800">
                            <div>
                                <p class="font-bold text-zinc-900 dark:text-white">{{ $item->especialidade->nome }}</p>
                                <p class="text-xs text-zinc-500">{{ __('Período selecionado') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-black text-zinc-900 dark:text-white">{{ $item->total }}</span>
                                <p class="text-[10px] font-bold uppercase text-zinc-400">{{ __('Atendimentos') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-zinc-400">
                            <x-icons.document-text class="w-12 h-12 mb-3 opacity-20" />
                            <p>{{ __('Nenhum atendimento realizado no período.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
