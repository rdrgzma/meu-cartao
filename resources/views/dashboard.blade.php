@if(auth()->user()->funcao === 'parceiro' && !auth()->user()->can_access_dashboard)
    @php abort(403, 'Acesso restrito ao Dashboard.'); @endphp
@endif
<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-8">

        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    {{ __('Bem-vindo, :name!', ['name' => explode(' ', auth()->user()->name)[0]]) }}
                </h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Aqui está o resumo do seu sistema de benefícios.') }}
                </p>
            </div>
            <div class="text-sm text-zinc-400 font-mono">
                {{ now()->format('d/m/Y — H:i') }}
            </div>
        </div>

        {{-- Stats --}}
        <livewire:dashboard.stats />

        {{-- Quick Actions + Status --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Quick Actions --}}
            <div class="card-premium p-6">
                <h2 class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-5">
                    {{ __('Ações Rápidas') }}
                </h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('clientes.index') }}" wire:navigate
                        class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800 hover:border-blue-200 hover:bg-blue-50 dark:hover:border-blue-800 dark:hover:bg-blue-900/20 transition-all">
                        <div class="p-2.5 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                            <x-icons.users class="w-5 h-5" />
                        </div>
                        <span class="text-xs font-semibold text-center">{{ __('Clientes') }}</span>
                    </a>

                    <a href="{{ route('validacao.painel') }}" wire:navigate
                        class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800 hover:border-green-200 hover:bg-green-50 dark:hover:border-green-800 dark:hover:bg-green-900/20 transition-all">
                        <div class="p-2.5 rounded-xl bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                            <x-icons.shield-check class="w-5 h-5" />
                        </div>
                        <span class="text-xs font-semibold text-center">{{ __('Validação') }}</span>
                    </a>

                    <a href="{{ route('financeiro.index') }}" wire:navigate
                        class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800 hover:border-amber-200 hover:bg-amber-50 dark:hover:border-amber-800 dark:hover:bg-amber-900/20 transition-all">
                        <div class="p-2.5 rounded-xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                            <x-icons.banknotes class="w-5 h-5" />
                        </div>
                        <span class="text-xs font-semibold text-center">{{ __('Financeiro') }}</span>
                    </a>

                    <a href="{{ route('parceiros.index') }}" wire:navigate
                        class="group flex flex-col items-center gap-3 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800 hover:border-purple-200 hover:bg-purple-50 dark:hover:border-purple-800 dark:hover:bg-purple-900/20 transition-all">
                        <div class="p-2.5 rounded-xl bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                            <x-icons.building-library class="w-5 h-5" />
                        </div>
                        <span class="text-xs font-semibold text-center">{{ __('Parceiros') }}</span>
                    </a>
                </div>
            </div>

            {{-- System Status --}}
            <div class="card-premium p-6">
                <h2 class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-5">
                    {{ __('Status do Sistema') }}
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ __('Sistema Online') }}</span>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 font-semibold">
                            {{ __('Operando') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ __('Notificações WhatsApp') }}</span>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-semibold">
                            {{ __('Ativo') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <span class="h-2 w-2 rounded-full bg-purple-500"></span>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ __('Cobrança Automática') }}</span>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 font-semibold">
                            {{ __('Ativo') }}
                        </span>
                    </div>

                    <div class="mt-2 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between text-xs text-zinc-400">
                        <span>{{ __('Versão da Plataforma') }}</span>
                        <code class="font-mono">v4.0.0</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
