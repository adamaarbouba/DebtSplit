<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-3xl text-gray-900 dark:text-white leading-tight tracking-tighter">
                    {{ $colocation->title }}
                </h2>
                <div class="flex items-center mt-2 space-x-3">
                    <span
                        class="px-2 py-0.5 text-xs font-black uppercase tracking-widest rounded {{ $colocation->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' }}">
                        {{ $colocation->status }}
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                @if ($colocation->owner_id === auth()->id())
                    <form action="{{ route('colocation.cancel', $colocation->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel this colocation? This action cannot be undone.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-5 py-2.5 bg-white dark:bg-[#161615] border border-red-300 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl text-xs font-bold transition hover:bg-red-50 dark:hover:bg-red-900/40">
                            Cancel Colocation
                        </button>
                    </form>

                    <a href="{{ route('category.index', $colocation->id) }}"
                        class="inline-block px-5 py-2.5 bg-gray-100 dark:bg-[#2A2A28] border border-gray-200 dark:border-[#3E3E3A] text-gray-900 dark:text-white rounded-xl text-xs font-bold transition hover:bg-gray-200 dark:hover:bg-[#3E3E3A]">
                        Manage Categories
                    </a>
                @endif

                <form action="{{ route('colocation.leave', $colocation->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to leave? If you have unpaid debts, your reputation will decrease!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-block px-5 py-2.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-xl text-xs font-bold transition hover:bg-red-600 hover:text-white dark:hover:bg-red-600 dark:hover:text-white">
                        Leave House
                    </button>
                </form>

                <a href="{{ route('expense.index') }}"
                    class="inline-block px-5 py-2.5 bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] text-gray-900 dark:text-gray-100 rounded-xl text-xs font-bold transition hover:bg-gray-50 dark:hover:bg-white/5">
                    View Expenses
                </a>

                <a href="{{ route('expense.create', $colocation->id) }}"
                    class="inline-block px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-xs font-bold transition hover:bg-[#d92602] dark:hover:bg-[#f53003] dark:hover:text-white">
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
                        class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-gray-200 dark:border-[#3E3E3A]">
                        <h3 class="text-xs font-black text-gray-600 dark:text-gray-300 uppercase tracking-[0.2em] mb-4">
                            My Current Debt
                        </h3>
                        <p
                            class="text-5xl font-black tracking-tighter {{ $colocation->pivot->debt > 0 ? 'text-[#d92602] dark:text-[#f53003]' : 'text-green-600 dark:text-green-400' }}">
                            {{ number_format($colocation->pivot->debt, 2) }} <span class="text-sm">DH</span>
                        </p>
                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-[#3E3E3A]">
                            <p
                                class="text-xs text-gray-600 dark:text-gray-300 italic uppercase font-bold tracking-widest">
                                Joined {{ \Carbon\Carbon::parse($colocation->pivot->joined_at)->format('M Y') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-gray-200 dark:border-[#3E3E3A]">
                        <h3 class="text-xs font-black text-gray-600 dark:text-gray-300 uppercase tracking-[0.2em] mb-6">
                            Active Categories
                        </h3>
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
                        class="bg-white dark:bg-[#161615] rounded-2xl border border-gray-200 dark:border-[#3E3E3A] overflow-hidden">
                        <div
                            class="p-8 border-b border-gray-100 dark:border-[#3E3E3A] flex justify-between items-center">
                            <h3 class="font-black text-xl tracking-tighter text-gray-900 dark:text-white">House
                                Roommates</h3>

                            @if ($colocation->owner_id === auth()->id())
                                <div
                                    class="flex items-center gap-2 bg-gray-50 dark:bg-[#0a0a0a] border border-gray-200 dark:border-[#3E3E3A] px-4 py-2 rounded-lg">
                                    <span
                                        class="text-xs font-black text-gray-600 dark:text-gray-300 uppercase tracking-widest">
                                        Invite Token:
                                    </span>
                                    <code
                                        class="text-sm font-black text-[#d92602] dark:text-[#f53003] tracking-widest select-all cursor-text">
                                        {{ $colocation->token }}
                                    </code>

                                    <form action="{{ route('colocation.token.refresh', $colocation->id) }}"
                                        method="POST" class="ml-2 flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" aria-label="Generate New Token"
                                            title="Generate New Token"
                                            onclick="return confirm('Generate a new token? The old one will instantly stop working.');"
                                            class="text-gray-500 hover:text-[#d92602] dark:hover:text-[#f53003] transition-colors p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead
                                    class="bg-gray-50 dark:bg-[#0a0a0a] text-gray-600 dark:text-gray-300 text-xs font-black uppercase tracking-[0.15em]">
                                    <tr>
                                        <th scope="col" class="px-8 py-4">Member</th>
                                        <th scope="col" class="px-8 py-4">Role</th>
                                        <th scope="col" class="px-8 py-4 text-right">Balance</th>
                                        <th scope="col" class="px-8 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
                                    @foreach ($colocation->users as $roommate)
                                        <tr
                                            class="{{ $roommate->id === auth()->id() ? 'bg-gray-50/50 dark:bg-white/5' : '' }}">
                                            <td class="px-8 py-5 flex items-center space-x-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-gray-900 dark:bg-white flex items-center justify-center font-black text-white dark:text-gray-900 text-xs">
                                                    {{ strtoupper(substr($roommate->name, 0, 1)) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="font-bold text-gray-900 dark:text-white tracking-tight">
                                                        {{ $roommate->name }}
                                                    </span>
                                                    @if ($roommate->id === $colocation->owner_id)
                                                        <span
                                                            class="text-[10px] font-black text-[#d92602] dark:text-[#f53003] uppercase tracking-widest mt-0.5">Owner</span>
                                                    @else
                                                        <span
                                                            class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mt-0.5">Member</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td
                                                class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-gray-600 dark:text-gray-300">
                                                {{ $roommate->pivot->role ?? 'Unknown' }}
                                            </td>
                                            <td
                                                class="px-8 py-5 text-right font-black tracking-tight {{ $roommate->pivot->debt > 0 ? 'text-[#d92602] dark:text-[#f53003]' : 'text-green-600 dark:text-green-400' }}">
                                                {{ number_format($roommate->pivot->debt, 2) }} <span
                                                    class="text-[10px]">DH</span>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                @if ($colocation->owner_id === auth()->id() && $roommate->id !== auth()->id())
                                                    <form
                                                        action="{{ route('colocation.kick', ['colocation' => $colocation->id, 'user' => $roommate->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to kick {{ $roommate->name }}? Any debt they have will be transferred to YOU!');"
                                                            class="text-xs font-black text-red-600 dark:text-red-400 uppercase tracking-widest hover:underline px-3 py-1 rounded bg-red-50 dark:bg-red-900/30">
                                                            Kick
                                                        </button>
                                                    </form>
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
