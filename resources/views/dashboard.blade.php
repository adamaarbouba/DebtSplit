<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black dark:text-white leading-tight tracking-tighter">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-[#19140010] dark:border-[#3E3E3A] sm:rounded-2xl">
                <div class="p-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-[#706f6c] dark:text-[#A1A09A]">Good morning,</h3>
                        <p class="text-3xl font-black tracking-tight text-black dark:text-white">
                            {{ auth()->user()->name }}</p>
                    </div>

                    <a href="{{ route('colocation.index') }}"
                        class="px-6 py-3 border border-[#19140015] dark:border-[#3E3E3A] text-black dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition duration-150">
                        {{ __('View History') }}
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="md:col-span-2 bg-white dark:bg-[#161615] border border-[#19140010] dark:border-[#3E3E3A] sm:rounded-2xl p-8">
                    <h4 class="text-xs font-black uppercase tracking-widest text-[#f53003] mb-6">
                        {{ __('Current Colocation') }}</h4>

                    @if ($activeColocation ?? null)
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div>
                                <h2 class="text-4xl font-black tracking-tighter text-black dark:text-white mb-2">
                                    {{ $activeColocation->title }}
                                </h2>
                                <p class="text-[#706f6c] dark:text-[#A1A09A] font-medium">
                                    Status: <span
                                        class="text-green-500 uppercase text-xs font-bold px-2 py-0.5 bg-green-50 dark:bg-green-900/20 rounded">Active</span>
                                </p>
                            </div>

                            <a href="{{ route('colocation.show', $activeColocation->id) }}"
                                class="w-full sm:w-auto text-center bg-[#f53003] hover:bg-[#d42a02] text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-105">
                                {{ __('Open Workspace') }}
                            </a>
                        </div>
                    @else
                        <div class="py-4">
                            <p class="text-[#706f6c] dark:text-[#A1A09A] italic">
                                {{ __('You are not currently active in any house.') }}</p>
                            <a href="{{ route('colocation.join') }}"
                                class="text-[#f53003] font-bold underline underline-offset-4 mt-2 inline-block">Join one
                                now &rarr;</a>
                        </div>
                        <div class="py-4">
                            <a href="{{ route('colocation.create') }}"
                                class="text-[#f53003] font-bold underline underline-offset-4 mt-2 inline-block">Create
                                Colocation &rarr;</a>
                        </div>
                    @endif
                </div>
                <div class="bg-black dark:bg-white p-8 sm:rounded-2xl flex flex-col justify-between">
                    <div class="text-white dark:text-black">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-60 mb-1">Quick Tip</p>
                        <p class="text-lg leading-snug">Keep your receipts updated to avoid house friction.</p>
                    </div>
                    <div class="mt-8">
                        <div class="w-12 h-1 bg-[#f53003]"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
