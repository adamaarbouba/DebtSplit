<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DebtSplit | Simple Expense Sharing</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] antialiased font-sans">
        
        <nav class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#f53003] rounded-lg flex items-center justify-center shadow-lg shadow-red-500/20">
                    <span class="text-white font-black text-xl leading-none">$</span>
                </div>
                <span class="text-xl font-bold tracking-tight dark:text-white">Debt<span class="text-[#f53003]">Split</span></span>
            </div>
            
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-black dark:bg-white text-white dark:text-black rounded-full text-sm font-semibold transition hover:scale-105">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium dark:text-gray-300 hover:text-[#f53003] transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 bg-[#f53003] text-white rounded-full text-sm font-semibold shadow-lg shadow-red-500/20 transition hover:scale-105">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <header class="max-w-5xl mx-auto px-6 pt-16 pb-24 text-center">
            <h1 class="text-6xl lg:text-8xl font-black tracking-tighter leading-[0.9] dark:text-white mb-8">
                Shared living. <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#f53003] to-orange-500">Simple math.</span>
            </h1>
            <p class="text-lg lg:text-xl text-[#706f6c] dark:text-[#A1A09A] max-w-2xl mx-auto leading-relaxed mb-10">
                The easiest way to track house expenses, split bills, and manage debts without the awkward conversations. Built for modern colocations.
            </p>
            
            <div class="flex justify-center gap-4">
                 <div class="flex -space-x-3 overflow-hidden">
                    @foreach([1,2,3,4] as $i)
                        <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white dark:ring-[#0a0a0a] bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-[10px] font-bold">U{{$i}}</div>
                    @endforeach
                </div>
                <div class="text-sm self-center font-medium text-[#706f6c] dark:text-[#A1A09A] ml-2">
                    Joined by 1,000+ roommates
                </div>
            </div>
        </header>

        <section class="max-w-7xl mx-auto px-6 pb-32">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-[#161615] p-8 rounded-3xl border border-[#19140010] dark:border-[#3E3E3A] hover:border-[#f53003] transition-colors group">
                    <div class="w-12 h-12 bg-red-50 dark:bg-red-950/30 rounded-2xl flex items-center justify-center mb-6 text-[#f53003] group-hover:bg-[#f53003] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Create a House</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">Generate a unique token and invite your roommates in seconds. One house, one shared ledger.</p>
                </div>

                <div class="bg-white dark:bg-[#161615] p-8 rounded-3xl border border-[#19140010] dark:border-[#3E3E3A] hover:border-[#f53003] transition-colors group">
                    <div class="w-12 h-12 bg-red-50 dark:bg-red-950/30 rounded-2xl flex items-center justify-center mb-6 text-[#f53003] group-hover:bg-[#f53003] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Track Everything</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">From rent to groceries. Categorize your spending with custom colors and see real-time debt balances.</p>
                </div>

                <div class="bg-white dark:bg-[#161615] p-8 rounded-3xl border border-[#19140010] dark:border-[#3E3E3A] hover:border-[#f53003] transition-colors group">
                    <div class="w-12 h-12 bg-red-50 dark:bg-red-950/30 rounded-2xl flex items-center justify-center mb-6 text-[#f53003] group-hover:bg-[#f53003] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Settle Instantly</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">No more "who paid what." Clear your balance with a single click and keep your colocation vibes positive.</p>
                </div>
            </div>
        </section>

        <footer class="max-w-7xl mx-auto px-6 py-12 border-t border-[#19140010] dark:border-[#3E3E3A] flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-sm font-bold tracking-tight opacity-50">&copy; {{ date('Y') }} DEBTSPLIT.</div>
            <div class="flex gap-8 text-[10px] font-black uppercase tracking-widest text-[#706f6c]">
                <span>CodeWave</span>
                <span>Laravel SC</span>
                <span>MVC PHP</span>
            </div>
        </footer>

    </body>
</html>