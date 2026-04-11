<div class="flex flex-col md:flex-row gap-8">
    <aside class="w-full md:w-64 shrink-0">
        <nav class="space-y-1">
            <x-nav-item :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="users">{{ __('Perfil') }}</x-nav-item>
            <x-nav-item :href="route('security.edit')" :active="request()->routeIs('security.edit')" icon="shield-check">{{ __('Segurança') }}</x-nav-item>
            <x-nav-item :href="route('appearance.edit')" :active="request()->routeIs('appearance.edit')" icon="list-bullet">{{ __('Aparência') }}</x-nav-item>
        </nav>
    </aside>

    <div class="flex-1 max-w-3xl">
        <div class="card-premium p-6">
            <header class="mb-6">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $heading ?? '' }}</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $subheading ?? '' }}</p>
            </header>

            <div class="space-y-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
