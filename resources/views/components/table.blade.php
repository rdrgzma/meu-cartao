@props(['paginate' => null])

<div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 border-y border-zinc-200 dark:border-zinc-800">
            <tr>
                {{ $columns }}
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
            {{ $slot }}
        </tbody>
    </table>

    @if($paginate)
        <div class="mt-4 px-2">
            {{ $paginate->links() }}
        </div>
    @endif
</div>
