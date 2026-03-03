<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <a href="{{ route('expense.index') }}"
                    class="text-[10px] font-black uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A] hover:text-[#f53003] transition mb-2 inline-block">
                    &larr; Back to Expenses
                </a>
                <h2
                    class="font-black text-3xl text-black dark:text-white leading-tight tracking-tighter flex items-center gap-3">
                    Bill Details
                    <span
                        class="px-2 py-1 text-[10px] font-black uppercase tracking-widest text-white rounded text-base align-middle"
                        style="background-color: {{ $expense->category->color ?? '#1b1b18' }}">
                        {{ $expense->category->name ?? 'General' }}
                    </span>
                </h2>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <span
                    class="px-3 py-1.5 text-xs font-black uppercase tracking-widest rounded-xl border {{ $expense->status === 'PAID' ? 'bg-green-50 text-green-600 border-green-200 dark:bg-green-900/20 dark:border-green-900' : 'bg-red-50 text-red-600 border-red-200 dark:bg-red-900/20 dark:border-red-900' }}">
                    Overall Status: {{ $expense->status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    class="p-4 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-2xl text-sm font-bold border border-green-200 dark:border-green-900">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('info'))
                <div
                    class="p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl text-sm font-bold border border-blue-200 dark:border-blue-900">
                    {{ session('info') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Expense Summary --}}
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-[#19140010] dark:border-[#3E3E3A]">
                        <h3
                            class="text-[10px] font-black text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-[0.2em] mb-4">
                            Total Amount</h3>
                        <p class="text-5xl font-black tracking-tighter text-black dark:text-white">
                            {{ number_format($expense->total_payment, 2) }} <span class="text-sm">DH</span>
                        </p>

                        <div class="mt-8 pt-6 border-t border-gray-50 dark:border-[#3E3E3A] space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-bold text-[#706f6c] dark:text-[#A1A09A]">Logged By:</span>
                                <span
                                    class="font-black text-black dark:text-white">{{ $expense->creator->name ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-bold text-[#706f6c] dark:text-[#A1A09A]">Paid By:</span>
                                <span
                                    class="font-black text-black dark:text-white">{{ $expense->payer->name ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-bold text-[#706f6c] dark:text-[#A1A09A]">Date:</span>
                                <span
                                    class="font-black text-black dark:text-white">{{ $expense->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Split Breakdown --}}
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-[#161615] rounded-2xl border border-[#19140010] dark:border-[#3E3E3A] overflow-hidden">

                        <div class="p-8 border-b border-gray-50 dark:border-[#3E3E3A]">
                            <h3 class="font-black text-xl tracking-tighter dark:text-white">Split Breakdown</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead
                                    class="bg-gray-50/50 dark:bg-[#0a0a0a] text-[#706f6c] text-[10px] font-black uppercase tracking-[0.15em]">
                                    <tr>
                                        <th class="px-8 py-4">Roommate</th>
                                        <th class="px-8 py-4">Status</th>
                                        <th class="px-8 py-4 text-right">Share</th>
                                        <th class="px-8 py-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-[#3E3E3A]">
                                    @foreach ($expense->users as $roommate)
                                        <tr
                                            class="{{ $roommate->id === auth()->id() ? 'bg-gray-50/30 dark:bg-white/5' : '' }}">

                                            {{-- User Info --}}
                                            <td class="px-8 py-5 flex items-center space-x-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-black dark:bg-white flex items-center justify-center font-black text-white dark:text-black text-xs">
                                                    {{ strtoupper(substr($roommate->name, 0, 1)) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-black dark:text-white tracking-tight">
                                                        {{ $roommate->name }}
                                                    </span>
                                                    @if ($roommate->id === auth()->id())
                                                        <span
                                                            class="text-[9px] font-black text-[#f53003] uppercase tracking-widest mt-0.5">(You)</span>
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-8 py-5">
                                                <span
                                                    class="px-2 py-1 text-[9px] font-black uppercase tracking-widest rounded {{ $roommate->pivot->status === 'PAID' ? 'bg-green-50 text-green-600 dark:bg-green-900/20' : 'bg-red-50 text-red-600 dark:bg-red-900/20' }}">
                                                    {{ $roommate->pivot->status }}
                                                </span>
                                            </td>

                                            {{-- Amount --}}
                                            <td
                                                class="px-8 py-5 text-right font-black tracking-tight text-black dark:text-white">
                                                {{ number_format($roommate->pivot->amount, 2) }} <span
                                                    class="text-[10px] text-[#706f6c]">DH</span>
                                            </td>

                                            {{-- Action (Pay Button) --}}
                                            <td class="px-8 py-5 text-right">
                                                @if ($roommate->id === auth()->id() && $roommate->pivot->status === 'UNPAID')
                                                    <form
                                                        action="{{ route('expense.user.paid', ['colocation' => $expense->category->colocation_id, 'expense' => $expense->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            onclick="return confirm('Confirm you have paid {{ number_format($roommate->pivot->amount, 2) }} DH?');"
                                                            class="px-4 py-2 bg-[#f53003] hover:bg-[#d42a02] text-white rounded-lg text-xs font-bold transition-all hover:scale-105 shadow-md shadow-red-500/20">
                                                            Mark as Paid
                                                        </button>
                                                    </form>
                                                @elseif ($roommate->pivot->status === 'PAID')
                                                    <span
                                                        class="text-[10px] font-bold text-green-500 uppercase tracking-widest">Settled</span>
                                                @else
                                                    <span
                                                        class="text-[10px] font-bold text-[#706f6c] uppercase tracking-widest">Waiting</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
