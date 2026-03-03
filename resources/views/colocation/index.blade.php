<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight tracking-tighter">
            {{ __('My Colocations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($colocations as $colocation)
                    <div
                        class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 dark:border-[#3E3E3A] flex flex-col transition-all hover:border-[#f53003]/30">
                        <div class="p-8 flex-1">
                            <div class="flex justify-between items-start mb-6">
                                <h4 class="font-black text-2xl text-gray-900 dark:text-white tracking-tighter">
                                    {{ $colocation->title }}
                                </h4>
                                <span
                                    class="px-3 py-1 text-xs font-black uppercase tracking-widest rounded-full {{ $colocation->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' }}">
                                    {{ $colocation->status }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300">
                                    <span class="mr-2">👥</span>
                                    {{ $colocation->users_count }} {{ __('Roommates') }}
                                </div>

                                <div
                                    class="p-4 bg-gray-50 dark:bg-[#0a0a0a] rounded-xl border border-gray-100 dark:border-[#3E3E3A]">
                                    <p
                                        class="text-xs font-black uppercase tracking-widest text-gray-600 dark:text-gray-400 mb-1">
                                        Your Balance
                                    </p>
                                    <p
                                        class="text-xl font-black tracking-tight {{ $colocation->pivot->debt > 0 ? 'text-[#d92602] dark:text-[#f53003]' : 'text-green-600 dark:text-green-400' }}">
                                        {{ number_format($colocation->pivot->debt, 2) }} DH
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Area --}}
                        <div class="bg-white dark:bg-[#161615] p-6 border-t border-gray-100 dark:border-[#3E3E3A]">
                            @if ($colocation->status === 'active')
                                <a href="{{ route('colocation.show', $colocation->id) }}"
                                    class="block w-full text-center bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold py-3 px-4 rounded-xl transition duration-150 hover:bg-[#d92602] dark:hover:bg-[#f53003] dark:hover:text-white hover:text-white">
                                    {{ __('View Workspace') }}
                                </a>
                            @else
                                <button disabled
                                    class="block w-full text-center bg-gray-100 dark:bg-[#2A2A28] text-gray-400 dark:text-gray-500 font-bold py-3 px-4 rounded-xl cursor-not-allowed">
                                    {{ __('Archived') }}
                                </button>
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-3 italic">
                                    This colocation is currently {{ $colocation->status }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full bg-white dark:bg-[#161615] p-16 rounded-2xl border border-dashed border-gray-300 dark:border-[#3E3E3A] text-center">
                        <p class="text-gray-600 dark:text-gray-300 font-medium text-lg">
                            {{ __('No history found. Start your first colocation to begin.') }}
                        </p>
                        <a href="{{ route('dashboard') }}"
                            class="text-[#d92602] dark:text-[#f53003] font-bold underline underline-offset-4 mt-4 inline-block">
                            Go back to dashboard
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
