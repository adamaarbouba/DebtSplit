<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DebtSplit') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-[#0a0a0a] border-b border-[#19140005] dark:border-[#3E3E3A]">
                <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            <div class="transition-opacity duration-750 opacity-100">
                {{ $slot }}
            </div>
        </main>
    </div>

    <footer class="max-w-7xl mx-auto px-6 py-12 opacity-30">
        <p class="text-[10px] font-black uppercase tracking-widest text-center">
            &copy; {{ date('Y') }} DEBTSPLIT SYSTEM
        </p>
    </footer>
</body>

</html>
