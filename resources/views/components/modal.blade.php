@props(['name', 'title' => ''])

<div
    x-data="{ show: false, name: '{{ $name }}' }"
    x-show="show"
    x-on:open-modal.window="show = ($event.detail === name || (typeof $event.detail === 'object' && ($event.detail.name === name || $event.detail[0] === name)))"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Overlay -->
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal Content -->
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div 
            x-show="show" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-zinc-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg lg:max-w-2xl border border-zinc-200 dark:border-zinc-800"
            @click.away="show = false"
        >
            <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h3>
                <button @click="show = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
