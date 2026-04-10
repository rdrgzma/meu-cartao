<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Clientes Ativos -->
    <div class="card-premium p-5 flex items-center gap-4">
        <div class="p-3 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-xl">
            <x-icons.users class="w-6 h-6" />
        </div>
        <div>
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-wider">{{ __('Clientes Ativos') }}</p>
            <h4 class="text-2xl font-bold mt-1 text-zinc-900 dark:text-white">
                {{ number_format($stats['clientes_ativos'], 0, ',', '.') }}
            </h4>
        </div>
    </div>

    <!-- Inadimplentes -->
    <div class="card-premium p-5 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
        <div class="p-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl px-4">
            <x-icons.shield-check class="w-6 h-6" />
        </div>
        <div>
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-wider">{{ __('Inadimplentes') }}</p>
            <h4 class="text-2xl font-bold mt-1 text-zinc-900 dark:text-white">
                {{ number_format($stats['clientes_inadimplentes'], 0, ',', '.') }}
            </h4>
        </div>
    </div>

    <!-- Faturamento Mês -->
    <div class="card-premium p-5 flex items-center gap-4">
        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl px-4">
            <x-icons.banknotes class="w-6 h-6" />
        </div>
        <div>
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-wider">{{ __('Faturamento Mês') }}</p>
            <h4 class="text-xl font-bold mt-1 text-zinc-900 dark:text-white truncate">
                R$ {{ number_format($stats['faturamento_mes'], 2, ',', '.') }}
            </h4>
        </div>
    </div>

    <!-- Parceiros Ativos -->
    <div class="card-premium p-5 flex items-center gap-4">
        <div class="p-3 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-xl px-4">
            <x-icons.home class="w-6 h-6" />
        </div>
        <div>
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-wider">{{ __('Rede Parceira') }}</p>
            <h4 class="text-2xl font-bold mt-1 text-zinc-900 dark:text-white">
                {{ $stats['parceiros_ativos'] }} Unid.
            </h4>
        </div>
    </div>
</div>
