<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Irvana Buah') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background:var(--bg-base);color:var(--text-primary);">
        <div style="min-height:100vh;display:flex;flex-direction:column;position:relative;z-index:1;">
            @include('layouts.navigation')

            @isset($header)
                <header style="background:rgba(255,255,255,0.02);border-bottom:1px solid var(--glass-border);padding:1.25rem 1rem;">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main style="flex:1;">
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>

        @stack('scripts')
    </body>
</html>
