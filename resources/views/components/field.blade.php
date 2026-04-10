@props(['label' => '', 'error' => ''])

<div class="space-y-1">
    @if($label)
        <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
            {{ $label }}
        </label>
    @endif

    {{ $slot }}

    @if($error)
        <p class="text-xs text-red-500 mt-1">{{ $error }}</p>
    @endif
</div>
