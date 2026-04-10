<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    {{-- Dark mode preference BEFORE paint to avoid flash --}}
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>
</head>
<body
    class="min-h-screen bg-zinc-100 dark:bg-zinc-950 font-sans text-zinc-900 dark:text-zinc-100 antialiased"
    x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        darkMode: localStorage.getItem('theme') !== 'light',
        toggleDark() {
            this.darkMode = !this.darkMode;
            const theme = this.darkMode ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
            document.documentElement.classList.toggle('dark', this.darkMode);
        }
    }"
>
    {{-- Overlay mobile --}}
    <div
        x-show="sidebarOpen && window.innerWidth < 1024"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm lg:hidden"
        x-transition:enter="transition-opacity duration-200"
        x-transition:leave="transition-opacity duration-200 ease-in"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Sidebar --}}
    <aside
        class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900 transition-transform duration-300"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        {{-- Logo --}}
        <div class="flex h-16 items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 px-5">
            <x-app-logo class="h-7 w-auto text-zinc-900 dark:text-white" />
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-6">
            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                    {{ __('Plataforma') }}
                </p>
                <div class="space-y-0.5">
                    <x-nav-item :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">{{ __('Dashboard') }}</x-nav-item>
                    <x-nav-item :href="route('clientes.index')" :active="request()->routeIs('clientes.*')" icon="users">{{ __('Clientes') }}</x-nav-item>
                    <x-nav-item :href="route('especialidades.index')" :active="request()->routeIs('especialidades.*')" icon="academic-cap">{{ __('Especialidades') }}</x-nav-item>
                    <x-nav-item :href="route('planos.index')" :active="request()->routeIs('planos.*')" icon="list-bullet">{{ __('Planos') }}</x-nav-item>
                    <x-nav-item :href="route('financeiro.index')" :active="request()->routeIs('financeiro.*')" icon="banknotes">{{ __('Financeiro') }}</x-nav-item>
                    <x-nav-item :href="route('parceiros.index')" :active="request()->routeIs('parceiros.*')" icon="building-library">{{ __('Parceiros') }}</x-nav-item>
                    <x-nav-item :href="route('validacao.painel')" :active="request()->routeIs('validacao.*')" icon="shield-check">{{ __('Validação') }}</x-nav-item>
                </div>
            </div>

            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                    {{ __('Comunicação') }}
                </p>
                <div class="space-y-0.5">
                    <x-nav-item :href="route('notificacoes.config')" :active="request()->routeIs('notificacoes.config')" icon="chat-bubble-left-right">{{ __('WhatsApp') }}</x-nav-item>
                    <x-nav-item :href="route('notificacoes.logs')" :active="request()->routeIs('notificacoes.logs')" icon="document-text">{{ __('Logs') }}</x-nav-item>
                </div>
            </div>

            <div>
                <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                    {{ __('Administração') }}
                </p>
                <div class="space-y-0.5">
                    <x-nav-item :href="route('sistema.usuarios')" :active="request()->routeIs('sistema.usuarios')" icon="user-group">{{ __('Usuários') }}</x-nav-item>
                    <x-nav-item :href="route('sistema.unidades')" :active="request()->routeIs('sistema.unidades')" icon="building-library">{{ __('Unidades') }}</x-nav-item>
                    <x-nav-item :href="route('relatorios.financeiro')" :active="request()->routeIs('relatorios.*')" icon="document-text">{{ __('Relatórios') }}</x-nav-item>
                </div>
            </div>
        </nav>

        {{-- User Footer --}}
        <div class="border-t border-zinc-100 dark:border-zinc-800 p-4">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 shrink-0 rounded-full bg-gradient-to-br from-zinc-700 to-zinc-900 dark:from-zinc-300 dark:to-zinc-100 flex items-center justify-center text-white dark:text-zinc-900 font-bold text-xs uppercase">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="truncate text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <button
                    onclick="document.getElementById('logout-form').submit()"
                    title="Sair"
                    class="shrink-0 p-1.5 rounded-lg text-zinc-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex min-h-screen flex-col transition-all duration-300" :class="sidebarOpen ? 'lg:pl-64' : ''">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-zinc-200 bg-white/90 dark:border-zinc-800 dark:bg-zinc-950/90 backdrop-blur-md px-4 lg:px-6">
            {{-- Mobile menu button --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="p-2 rounded-lg text-zinc-500 hover:text-zinc-700 hover:bg-zinc-100 dark:hover:text-zinc-300 dark:hover:bg-zinc-800 transition-colors"
                :title="sidebarOpen ? 'Fechar menu' : 'Abrir menu'"
            >
                <svg x-show="!sidebarOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="sidebarOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Page title (from wire:title or page heading) --}}
            @if(isset($title))
                <h2 class="hidden sm:block text-sm font-semibold text-zinc-500 dark:text-zinc-400">{{ $title }}</h2>
            @endif

            {{-- Spacer --}}
            <div class="flex-1"></div>

            {{-- Dark mode toggle --}}
            <button
                @click="toggleDark()"
                class="p-2 rounded-lg text-zinc-500 hover:text-zinc-700 hover:bg-zinc-100 dark:hover:text-zinc-300 dark:hover:bg-zinc-800 transition-colors"
                :title="darkMode ? 'Mudar para modo claro' : 'Mudar para modo escuro'"
            >
                {{-- Sun icon (light mode) --}}
                <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                {{-- Moon icon (dark mode) --}}
                <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>

            {{-- Settings --}}
            @if(Route::has('profile.edit'))
            <a
                href="{{ route('profile.edit') }}"
                class="p-2 rounded-lg text-zinc-500 hover:text-zinc-700 hover:bg-zinc-100 dark:hover:text-zinc-300 dark:hover:bg-zinc-800 transition-colors"
                title="Configurações"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
            @endif
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    @livewireScripts
</body>
</html>
