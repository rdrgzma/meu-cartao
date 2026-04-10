<x-layouts.auth :title="__('Acessar ZapFlow Health')">
    <div x-data="{ 
        tab: 'login',
        copyToClipboard(text, type) {
            document.getElementsByName('email')[0].value = text;
            document.getElementsByName('password')[0].value = 'password';
            this.tab = 'login';
        }
    }" class="flex flex-col gap-8 relative px-2">
        
        {{-- Header --}}
        <div class="text-center space-y-2">
            <div class="inline-flex p-3 bg-emerald-500 rounded-2xl shadow-[0_0_30px_rgba(16,185,129,0.2)] mb-4">
                <x-icons.shield-check class="h-8 w-8 text-zinc-950" />
            </div>
            <h2 class="text-3xl font-black tracking-tighter text-zinc-900 dark:text-white uppercase">{{ __('ZapFlow') }} <span class="text-emerald-500">Health</span></h2>
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">{{ __('Inteligência e Gestão de Saúde') }}</p>
        </div>

        @if(config('app.debug'))
            <div class="flex p-1 bg-zinc-100 dark:bg-zinc-900/50 rounded-2xl border border-zinc-200/50 dark:border-white/5">
                <button @click="tab = 'login'" :class="tab === 'login' ? 'bg-white dark:bg-zinc-800 shadow-xl text-zinc-900 dark:text-white' : 'text-zinc-500'" class="flex-1 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                    Acesso
                </button>
                <button @click="tab = 'test'" :class="tab === 'test' ? 'bg-white dark:bg-zinc-800 shadow-xl text-zinc-900 dark:text-white' : 'text-zinc-500'" class="flex-1 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                    Sandbox
                </button>
            </div>
        @endif

        <div x-show="tab === 'login'" x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0 scale-95">
            <x-auth-session-status class="mb-6 text-center text-xs font-bold text-emerald-500" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                @csrf

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-zinc-400 ml-4">{{ __('E-mail Profissional') }}</label>
                    <input 
                        name="email" 
                        type="email" 
                        required 
                        autofocus 
                        placeholder="nome@empresa.com.br"
                        class="w-full px-5 py-4 rounded-2xl border border-zinc-200 dark:border-white/5 bg-white dark:bg-zinc-900 text-sm font-medium focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 outline-none transition-all shadow-sm"
                    >
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between px-4">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-400">{{ __('Senha de Acesso') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-black uppercase tracking-widest text-zinc-400 hover:text-emerald-500 transition-colors">
                                {{ __('Recuperar') }}
                            </a>
                        @endif
                    </div>
                    <input 
                        name="password" 
                        type="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-5 py-4 rounded-2xl border border-zinc-200 dark:border-white/5 bg-white dark:bg-zinc-900 text-sm font-medium focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 outline-none transition-all shadow-sm"
                    >
                </div>

                <div class="flex items-center justify-between px-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" class="peer h-5 w-5 rounded-lg border-zinc-300 dark:border-zinc-700 text-emerald-500 focus:ring-emerald-500/20 transition-all">
                        </div>
                        <span class="text-xs font-bold text-zinc-500 group-hover:text-zinc-800 dark:group-hover:text-zinc-200 transition-colors">{{ __('Manter conectado') }}</span>
                    </label>
                </div>

                <button type="submit" class="w-full h-14 bg-emerald-600 hover:bg-emerald-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl transition-all shadow-[0_10px_30px_rgba(16,185,129,0.3)] active:scale-[0.98]">
                    {{ __('Autenticar no OS') }}
                </button>
            </form>
        </div>

        @if(config('app.debug'))
            <div x-show="tab === 'test'" x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0 scale-95" class="space-y-4">
                <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500 mb-4 text-center">{{ __('Ambiente de Simulação') }}</p>
                    
                    <div class="space-y-2">
                        <button @click="copyToClipboard('sistema@cartaomaisaude.com.br')" class="w-full flex items-center justify-between p-4 rounded-xl border border-zinc-200 dark:border-white/5 bg-white dark:bg-zinc-900 hover:border-emerald-500/50 transition-all group">
                            <div class="text-left">
                                <p class="text-[11px] font-black uppercase tracking-widest text-zinc-900 dark:text-white">{{ __('ZAPFLOW ROOT') }}</p>
                                <p class="text-[10px] text-zinc-500">Super Administrator</p>
                            </div>
                            <x-icons.chevron-right class="w-4 h-4 text-zinc-300 group-hover:text-emerald-500 transition-colors" />
                        </button>

                        <button @click="copyToClipboard('admin@matriz.com.br')" class="w-full flex items-center justify-between p-4 rounded-xl border border-zinc-200 dark:border-white/5 bg-white dark:bg-zinc-900 hover:border-emerald-500/50 transition-all group">
                            <div class="text-left">
                                <p class="text-[11px] font-black uppercase tracking-widest text-zinc-900 dark:text-white">{{ __('TENANT ADMIN') }}</p>
                                <p class="text-[10px] text-zinc-500">Operadora Matriz</p>
                            </div>
                            <x-icons.chevron-right class="w-4 h-4 text-zinc-300 group-hover:text-emerald-500 transition-colors" />
                        </button>

                        <button @click="copyToClipboard('parceiro@matriz.com.br')" class="w-full flex items-center justify-between p-4 rounded-xl border border-zinc-200 dark:border-white/5 bg-white dark:bg-zinc-900 hover:border-emerald-500/50 transition-all group">
                            <div class="text-left">
                                <p class="text-[11px] font-black uppercase tracking-widest text-zinc-900 dark:text-white">{{ __('OPERACIONAL') }}</p>
                                <p class="text-[10px] text-zinc-500">Prestador de Serviço</p>
                            </div>
                            <x-icons.chevron-right class="w-4 h-4 text-zinc-300 group-hover:text-emerald-500 transition-colors" />
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="pt-4 text-center">
            <div class="flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest text-zinc-400">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                {{ __('Sistemas Críticos Protegidos') }}
            </div>
        </div>
    </div>
</x-layouts.auth>
