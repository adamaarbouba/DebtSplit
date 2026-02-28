<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-3xl text-black dark:text-white leading-tight tracking-tighter">
                    {{ $colocation->title }}
                </h2>
                <div class="flex items-center mt-2 space-x-3">
                    <span
                        class="px-2 py-0.5 text-[10px] font-black uppercase tracking-widest rounded {{ $colocation->status === 'active' ? 'bg-green-50 text-green-600 dark:bg-green-900/20' : 'bg-red-50 text-red-600' }}">
                        {{ $colocation->status }}
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Only the owner can see the Cancel button --}}
                @if ($colocation->owner_id === auth()->id())
                    <form action="{{ route('colocation.cancel', $colocation->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel this colocation? This action cannot be undone.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-5 py-2.5 bg-white dark:bg-[#161615] border border-red-200 dark:border-red-900/50 text-red-500 rounded-xl text-xs font-bold transition hover:bg-red-50 dark:hover:bg-red-900/20">
                            Cancel Colocation
                        </button>
                    </form>
                @endif

                {{-- NEW: Button to view the expenses index --}}
                <a href="{{ route('expense.index') }}"
                    class="inline-block px-5 py-2.5 bg-white dark:bg-[#161615] border border-[#19140010] dark:border-[#3E3E3A] text-black dark:text-white rounded-xl text-xs font-bold transition hover:bg-gray-50 dark:hover:bg-white/5">
                    View Expenses
                </a>

                <a href="{{ route('expense.create', $colocation->id) }}"
                    class="inline-block px-5 py-2.5 bg-black dark:bg-white text-white dark:text-black rounded-xl text-xs font-bold transition hover:bg-[#f53003] hover:text-white dark:hover:bg-[#f53003] dark:hover:text-white">
                    + Log Expense
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-[#19140010] dark:border-[#3E3E3A]">
                        <h3
                            class="text-[10px] font-black text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-[0.2em] mb-4">
                            My Current Debt</h3>
                        <p
                            class="text-5xl font-black tracking-tighter {{ $colocation->pivot->debt > 0 ? 'text-[#f53003]' : 'text-green-500' }}">
                            {{ number_format($colocation->pivot->debt, 2) }} <span class="text-sm">DH</span>
                        </p>
                        <div class="mt-8 pt-6 border-t border-gray-50 dark:border-[#3E3E3A]">
                            <p class="text-[10px] text-[#706f6c] italic uppercase font-bold tracking-widest">
                                Joined {{ \Carbon\Carbon::parse($colocation->pivot->joined_at)->format('M Y') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-[#19140010] dark:border-[#3E3E3A]">
                        <h3
                            class="text-[10px] font-black text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-[0.2em] mb-6">
                            Active Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($colocation->categories as $category)
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-white shadow-sm"
                                    style="background-color: {{ $category->color ?? '#1b1b18' }}">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-[#161615] rounded-2xl border border-[#19140010] dark:border-[#3E3E3A] overflow-hidden">

                        {{-- Roommates Header with Token --}}
                        <div
                            class="p-8 border-b border-gray-50 dark:border-[#3E3E3A] flex justify-between items-center">
                            <h3 class="font-black text-xl tracking-tighter dark:text-white">House Roommates</h3>

                            {{-- Only the owner can see the token label --}}
                            @if ($colocation->owner_id === auth()->id())
                                <div
                                    class="flex items-center gap-2 bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] px-4 py-2 rounded-lg">
                                    <span
                                        class="text-[10px] font-black text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-widest">Invite
                                        Token:</span>
                                    <code
                                        class="text-xs font-black text-[#f53003] tracking-widest select-all cursor-text">{{ $colocation->token }}</code>
                                </div>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead
                                    class="bg-gray-50/50 dark:bg-[#0a0a0a] text-[#706f6c] text-[10px] font-black uppercase tracking-[0.15em]">
                                    <tr>
                                        <th class="px-8 py-4">Member</th>
                                        <th class="px-8 py-4">Role</th>
                                        <th class="px-8 py-4 text-right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-[#3E3E3A]">
                                    @foreach ($colocation->users as $roommate)
                                        <tr
                                            class="{{ $roommate->id === auth()->id() ? 'bg-gray-50/30 dark:bg-white/5' : '' }}">
                                            <td class="px-8 py-5 flex items-center space-x-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-black dark:bg-white flex items-center justify-center font-black text-white dark:text-black text-xs">
                                                    {{ strtoupper(substr($roommate->name, 0, 1)) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-black dark:text-white tracking-tight">
                                                        {{ $roommate->name }}
                                                    </span>
                                                    @if ($roommate->id === $colocation->owner_id)
                                                        <span
                                                            class="text-[9px] font-black text-[#f53003] uppercase tracking-widest mt-0.5">Owner</span>
                                                    @else
                                                        <span
                                                            class="text-[9px] font-black text-[#f53003] uppercase tracking-widest mt-0.5">Member</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td
                                                class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-[#706f6c]">
                                                {{ $roommate->pivot->role ?? 'Unknown' }}
                                            </td>
                                            <td
                                                class="px-8 py-5 text-right font-black tracking-tight {{ $roommate->pivot->debt > 0 ? 'text-[#f53003]' : 'text-green-500' }}">
                                                {{ number_format($roommate->pivot->debt, 2) }} <span
                                                    class="text-[10px]">DH</span>
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
