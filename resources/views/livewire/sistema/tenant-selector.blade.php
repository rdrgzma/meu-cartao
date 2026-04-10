<div class="relative w-72" x-data="{ open: false, search: '' }">
    <button 
        @click="open = !open" 
        class="flex items-center justify-between w-full px-4 py-2 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-sm text-sm shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all text-left"
    >
        <span class="truncate flex items-center gap-2">
            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            {{ $selectedTenantId ? ($tenants->firstWhere('id', $selectedTenantId)->nome ?? __('Selecionar Organização')) : __('Visão Global (Sistema)') }}
        </span>
        <svg class="w-4 h-4 text-zinc-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div 
        x-show="open" 
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="absolute left-0 right-0 mt-2 z-50 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-2xl overflow-hidden"
        style="display: none;"
    >
        <div class="p-2 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/50">
            <div class="relative">
                <svg class="absolute left-2.5 top-2.5 w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input 
                    x-model="search" 
                    type="text" 
                    placeholder="Pesquisar organização..." 
                    class="w-full pl-8 pr-3 py-2 text-xs bg-white dark:bg-zinc-900 rounded-lg border border-zinc-100 dark:border-zinc-800 focus:ring-1 focus:ring-zinc-500 outline-none"
                    @keydown.escape="open = false"
                >
            </div>
        </div>
        <ul class="max-h-64 overflow-y-auto py-1 scrollbar-thin">
            <li 
                @click="$wire.set('selectedTenantId', ''); open = false"
                class="px-4 py-2.5 text-xs hover:bg-zinc-100 dark:hover:bg-zinc-800 cursor-pointer flex justify-between items-center {{ !$selectedTenantId ? 'bg-zinc-50 dark:bg-zinc-800 font-semibold text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }}"
            >
                <span>{{ __('Visão Global (Sistema)') }}</span>
                @if(!$selectedTenantId)
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
            </li>
            <div class="px-4 py-2 text-[10px] uppercase font-bold text-zinc-400 bg-zinc-50/50 dark:bg-zinc-800/30">{{ __('Organizações') }}</div>
            @foreach ($tenants as $tenant)
                <li 
                    x-show="!search || '{{ strtolower($tenant->nome) }}'.includes(search.toLowerCase())"
                    @click="$wire.set('selectedTenantId', '{{ $tenant->id }}'); open = false"
                    class="px-4 py-2.5 text-xs hover:bg-zinc-100 dark:hover:bg-zinc-800 cursor-pointer flex justify-between items-center {{ $selectedTenantId == $tenant->id ? 'bg-zinc-50 dark:bg-zinc-800 font-semibold text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }}"
                >
                    <span class="truncate">{{ $tenant->nome }}</span>
                    @if($selectedTenantId == $tenant->id)
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
