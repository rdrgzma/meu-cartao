@props(['href', 'active' => false, 'icon' => ''])

@php
$base = 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-150 group';
$activeClasses = 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-sm';
$inactiveClasses = 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-100';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$base " . ($active ? $activeClasses : $inactiveClasses)]) }} wire:navigate>
    @if($icon)
        <x-dynamic-component
            :component="'icons.' . $icon"
            :class="'w-4 h-4 shrink-0 ' . ($active ? 'opacity-100' : 'opacity-60 group-hover:opacity-100')"
        />
    @endif
    <span class="truncate">{{ $slot }}</span>
</a>
