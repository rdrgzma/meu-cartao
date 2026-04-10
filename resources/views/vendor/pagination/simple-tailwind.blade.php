@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex gap-2 items-center justify-between">

        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-600 bg-white border border-zinc-300 cursor-not-allowed leading-5 rounded-md dark:text-zinc-300 dark:bg-zinc-700 dark:border-zinc-600">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-800 bg-white border border-zinc-300 leading-5 rounded-md hover:text-zinc-700 focus:outline-none focus:ring ring-zinc-300 focus:border-blue-300 active:bg-zinc-100 active:text-zinc-800 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-zinc-200 dark:focus:border-blue-700 dark:active:bg-zinc-700 dark:active:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-900 dark:hover:text-zinc-200">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-800 bg-white border border-zinc-300 leading-5 rounded-md hover:text-zinc-700 focus:outline-none focus:ring ring-zinc-300 focus:border-blue-300 active:bg-zinc-100 active:text-zinc-800 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-zinc-200 dark:focus:border-blue-700 dark:active:bg-zinc-700 dark:active:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-900 dark:hover:text-zinc-200">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-600 bg-white border border-zinc-300 cursor-not-allowed leading-5 rounded-md dark:text-zinc-300 dark:bg-zinc-700 dark:border-zinc-600">
                {!! __('pagination.next') !!}
            </span>
        @endif

    </nav>
@endif
