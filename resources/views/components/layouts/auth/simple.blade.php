<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'dark';
                document.documentElement.classList.toggle('dark', theme === 'dark');
            })();
        </script>
    </head>
    <body class="min-h-screen bg-zinc-100 dark:bg-zinc-950 antialiased font-sans">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-3" wire:navigate>
                    <x-app-logo class="h-10 w-auto" />
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="card-premium p-8 shadow-xl">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
