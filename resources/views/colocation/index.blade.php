<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black dark:text-white leading-tight tracking-tighter">
            {{ __('My Colocations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($colocations as $colocation)
                    <div
                        class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm sm:rounded-2xl border border-[#19140010] dark:border-[#3E3E3A] flex flex-col transition-all hover:border-[#f53003]/30">
                        <div class="p-8 flex-1">
                            <div class="flex justify-between items-start mb-6">
                                <h4 class="font-black text-2xl text-black dark:text-white tracking-tighter">
                                    {{ $colocation->title }}
                                </h4>
                                <span
                                    class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full {{ $colocation->status === 'active' ? 'bg-green-50 text-green-600 dark:bg-green-900/20' : 'bg-gray-100 text-gray-500 dark:bg-[#3E3E3A] dark:text-[#A1A09A]' }}">
                                    {{ $colocation->status }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                                    <span class="mr-2">👥</span>
                                    {{ $colocation->users_count }} {{ __('Roommates') }}
                                </div>

                                <div
                                    class="p-4 bg-gray-50 dark:bg-[#0a0a0a] rounded-xl border border-[#19140005] dark:border-[#3E3E3A]">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-[#706f6c] mb-1">Your
                                        Balance</p>
                                    <p
                                        class="text-xl font-black tracking-tight {{ $colocation->pivot->debt > 0 ? 'text-red-500' : 'text-green-500' }}">
                                        {{ number_format($colocation->pivot->debt, 2) }} DH
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Area --}}
                        <div class="bg-white dark:bg-[#161615] p-6 border-t border-[#19140010] dark:border-[#3E3E3A]">
                            @if ($colocation->status === 'active')
                                <a href="{{ route('colocation.show', $colocation->id) }}"
                                    class="block w-full text-center bg-black dark:bg-white text-white dark:text-black font-bold py-3 px-4 rounded-xl transition duration-150 hover:bg-[#f53003] hover:text-white dark:hover:bg-[#f53003] dark:hover:text-white">
                                    {{ __('View Workspace') }}
                                </a>
                            @else
                                <button disabled
                                    class="block w-full text-center bg-gray-100 dark:bg-[#3E3E3A] text-gray-400 dark:text-gray-500 font-bold py-3 px-4 rounded-xl cursor-not-allowed">
                                    {{ __('Archived') }}
                                </button>
                                <p class="text-[10px] text-center text-[#706f6c] mt-3 italic">
                                    This colocation is currently {{ $colocation->status }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full bg-white dark:bg-[#161615] p-16 rounded-2xl border border-dashed border-[#19140020] dark:border-[#3E3E3A] text-center">
                        <p class="text-[#706f6c] dark:text-[#A1A09A] font-medium text-lg">
                            {{ __('No history found. Start your first colocation to begin.') }}
                        </p>
                        <a href="{{ route('dashboard') }}"
                            class="text-[#f53003] font-bold underline underline-offset-4 mt-4 inline-block">
                            Go back to dashboard
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
