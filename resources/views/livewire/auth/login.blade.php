<x-layouts.auth :title="__('Acessar Sistema')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Login') }}</h2>
            <p class="text-sm text-zinc-500 mt-1">{{ __('Entre com suas credenciais para gerenciar o cartão.') }}</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <x-field :label="__('E-mail')" :error="$errors->first('email')">
                <input 
                    name="email" 
                    type="email" 
                    value="{{ old('email', 'sistema@cartaomaisaude.com.br') }}" 
                    required 
                    autofocus 
                    class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all"
                >
            </x-field>

            <!-- Password -->
            <x-field :label="__('Senha')" :error="$errors->first('password')">
                <div class="relative">
                    <input 
                        name="password" 
                        type="password" 
                        value="password"
                        required 
                        class="w-full px-4 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white outline-none transition-all"
                    >
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="absolute -top-6 right-0 text-xs text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                            {{ __('Esqueceu a senha?') }}
                        </a>
                    @endif
                </div>
            </x-field>

            <!-- Remember Me -->
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Manter conectado') }}</span>
            </label>

            <x-button type="submit" variant="primary" class="w-full h-11">
                {{ __('Entrar no Sistema') }}
            </x-button>
        </form>

        @if (Route::has('register'))
            <div class="text-sm text-center text-zinc-500">
                <span>{{ __('Não tem uma conta?') }}</span>
                <a href="{{ route('register') }}" class="font-semibold text-zinc-900 dark:text-white hover:underline">{{ __('Cadastre-se') }}</a>
            </div>
        @endif
    </div>
</x-layouts.auth>
