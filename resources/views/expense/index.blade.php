<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black dark:text-white leading-tight tracking-tighter">
            {{ __('My Expenses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($expenses as $expense)
                    <a href="{{ route('expense.show', $expense->id) }}"
                        class="block bg-white dark:bg-[#161615] overflow-hidden shadow-sm sm:rounded-2xl border border-[#19140010] dark:border-[#3E3E3A] transition-all hover:border-[#f53003]/30 hover:shadow-md group">

                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span
                                        class="px-2 py-1 text-[9px] font-black uppercase tracking-widest text-white rounded"
                                        style="background-color: {{ $expense->category->color ?? '#1b1b18' }}">
                                        {{ $expense->category->name ?? 'General' }}
                                    </span>
                                </div>
                                <span
                                    class="px-2 py-0.5 text-[10px] font-black uppercase tracking-widest rounded {{ $expense->pivot->status === 'PAID' ? 'bg-green-50 text-green-600 dark:bg-green-900/20' : 'bg-red-50 text-red-600 dark:bg-red-900/20' }}">
                                    {{ $expense->pivot->status }}
                                </span>
                            </div>

                            <div class="space-y-1">
                                <p
                                    class="text-[10px] font-black uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A]">
                                    My Share
                                </p>
                                <p class="text-3xl font-black tracking-tighter text-black dark:text-white">
                                    {{ number_format($expense->pivot->amount, 2) }} <span class="text-sm">DH</span>
                                </p>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 dark:bg-[#0a0a0a] px-6 py-4 border-t border-[#19140010] dark:border-[#3E3E3A] flex justify-between items-center">
                            <p class="text-[10px] font-bold text-[#706f6c] dark:text-[#A1A09A]">
                                Total Bill: <span
                                    class="text-black dark:text-white">{{ number_format($expense->total_payment, 2) }}
                                    DH</span>
                            </p>
                            <p class="text-[10px] font-bold text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $expense->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-full bg-white dark:bg-[#161615] p-16 rounded-2xl border border-dashed border-[#19140020] dark:border-[#3E3E3A] text-center">
                        <p class="text-[#706f6c] dark:text-[#A1A09A] font-medium text-lg">
                            {{ __('You have no expenses logged yet.') }}
                        </p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
