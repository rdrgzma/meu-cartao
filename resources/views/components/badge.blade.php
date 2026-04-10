@props(['color' => 'zinc'])

@php
$colors = [
    'zinc' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
    'green' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    'red' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
];

$classes = $colors[$color] ?? $colors['zinc'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ' . $classes]) }}>
    {{ $slot }}
</span>
