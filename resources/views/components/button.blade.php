@props(['variant' => 'primary', 'size' => 'md', 'icon' => ''])

@php
$variants = [
    'primary' => 'bg-zinc-900 border-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:border-white dark:text-zinc-900 dark:hover:bg-zinc-100',
    'secondary' => 'bg-white border-zinc-200 text-zinc-900 hover:bg-zinc-50 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white dark:hover:bg-zinc-700',
    'ghost' => 'bg-transparent border-transparent text-zinc-500 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800',
    'danger' => 'bg-red-600 border-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:border-red-500',
];

$sizes = [
    'sm' => 'px-2.5 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$classes = ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-lg font-medium border transition-all active:scale-95 disabled:opacity-50 ' . $classes]) }}>
    @if($icon)
        <x-dynamic-component :component="'icons.' . $icon" :class="$size === 'sm' ? 'w-4 h-4' : 'w-5 h-5'" />
    @endif
    {{ $slot }}
</button>
