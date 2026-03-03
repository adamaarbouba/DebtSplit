<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight tracking-tighter">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Greeting Card --}}
            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-gray-200 dark:border-[#3E3E3A] sm:rounded-2xl">
                <div class="p-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-center md:text-left">
                        <h3 class="text-lg font-medium text-gray-600 dark:text-gray-400">Good morning,</h3>
                        <p class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">
                            {{ auth()->user()->name }}
                        </p>
                    </div>

                    <a href="{{ route('colocation.index') }}"
                        class="w-full md:w-auto text-center px-6 py-3 border border-gray-200 dark:border-[#3E3E3A] text-gray-900 dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition duration-150">
                        {{ __('View History') }}
                    </a>
                </div>
            </div>

            {{-- Workspace Card --}}
            <div class="bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] sm:rounded-2xl p-8">

                @if ($activeColocation ?? null)
                    <h4 class="text-xs font-black uppercase tracking-widest text-[#d92602] dark:text-[#f53003] mb-6">
                        {{ __('Current Colocation') }}
                    </h4>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <h2 class="text-4xl font-black tracking-tighter text-gray-900 dark:text-white mb-2">
                                {{ $activeColocation->title }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 font-medium">
                                Status: <span
                                    class="uppercase text-xs font-bold px-2 py-0.5 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded">Active</span>
                            </p>
                        </div>

                        <a href="{{ route('colocation.show', $activeColocation->id) }}"
                            class="w-full sm:w-auto text-center bg-[#f53003] hover:bg-[#d42a02] text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-105">
                            {{ __('Open Workspace') }}
                        </a>
                    </div>
                @else
                    <div class="py-12 flex flex-col items-center justify-center text-center">
                        <div
                            class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-black tracking-tighter text-gray-900 dark:text-white mb-3">
                            No Active Workspace
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-8 leading-relaxed">
                            You are not currently active in any house. Create a new colocation or join your roommates
                            using an invite token to get started.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                            <a href="{{ route('colocation.create') }}"
                                class="w-full sm:w-auto text-center bg-[#f53003] hover:bg-[#d42a02] text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-105">
                                Create Colocation
                            </a>
                            <a href="{{ route('colocation.join') }}"
                                class="w-full sm:w-auto text-center bg-gray-100 dark:bg-[#2A2A28] border border-transparent hover:border-gray-200 dark:hover:border-[#3E3E3A] text-gray-900 dark:text-white font-bold py-3 px-8 rounded-xl transition-all">
                                Join with Token
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
