<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Aparência')" :subheading=" __('Personalize o visual do sistema conforme sua preferência.')">
        <div x-data="{ 
            theme: localStorage.getItem('theme') || 'dark',
            setTheme(val) {
                this.theme = val;
                localStorage.setItem('theme', val);
                
                if (val === 'system') {
                    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    document.documentElement.classList.toggle('dark', isDark);
                } else {
                    document.documentElement.classList.toggle('dark', val === 'dark');
                }
                
                // Emite evento para outros componentes se necessário
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: val }));
            }
        }" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <button @click="setTheme('light')" 
                :class="theme === 'light' ? 'ring-2 ring-zinc-900 border-zinc-900 dark:ring-white dark:border-white bg-white dark:bg-zinc-800' : 'bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800'" 
                class="p-4 rounded-xl border-2 text-center transition-all group">
                <x-icons.sun class="w-6 h-6 mx-auto mb-2 text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors" />
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('Claro') }}</span>
            </button>

            <button @click="setTheme('dark')" 
                :class="theme === 'dark' ? 'ring-2 ring-zinc-900 border-zinc-900 dark:ring-white dark:border-white bg-white dark:bg-zinc-800' : 'bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800'" 
                class="p-4 rounded-xl border-2 text-center transition-all group">
                <x-icons.moon class="w-6 h-6 mx-auto mb-2 text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors" />
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('Escuro') }}</span>
            </button>

            <button @click="setTheme('system')" 
                :class="theme === 'system' ? 'ring-2 ring-zinc-900 border-zinc-900 dark:ring-white dark:border-white bg-white dark:bg-zinc-800' : 'bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800'" 
                class="p-4 rounded-xl border-2 text-center transition-all group">
                <x-icons.computer-desktop class="w-6 h-6 mx-auto mb-2 text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors" />
                <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('Sistema') }}</span>
            </button>

        </div>
    </x-settings.layout>
</section>
