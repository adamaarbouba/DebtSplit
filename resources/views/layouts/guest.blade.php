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
    <body class="font-sans text-[#1b1b18] antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="mb-8 transition hover:scale-105 duration-300">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-[#f53003] rounded-xl flex items-center justify-center shadow-lg shadow-red-500/20">
                        <span class="text-white font-black text-2xl leading-none">$</span>
                    </div>
                    <span class="text-2xl font-bold tracking-tighter dark:text-white">
                        Debt<span class="text-[#f53003]">Split</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white dark:bg-[#161615] border border-[#19140010] dark:border-[#3E3E3A] shadow-sm overflow-hidden sm:rounded-3xl">
                <div class="mb-6 text-center">
                    <h2 class="text-xl font-bold tracking-tight dark:text-white">{{ $title ?? 'Welcome back' }}</h2>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1 uppercase tracking-widest font-semibold">Secure Access</p>
                </div>

                {{ $slot }}
            </div>

            <footer class="mt-8">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#706f6c] opacity-40">
                    &copy; {{ date('Y') }} DEBTSPLIT
                </p>
            </footer>
        </div>
    </body>
</html>