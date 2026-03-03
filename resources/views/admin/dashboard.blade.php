<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-900 dark:text-white leading-tight tracking-tighter">
            {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Statistics Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-gray-200 dark:border-[#3E3E3A] flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-gray-600 dark:text-gray-300 uppercase tracking-[0.2em] mb-2">
                            Total Standard Users
                        </h3>
                        <p class="text-5xl font-black tracking-tighter text-gray-900 dark:text-white">
                            {{ $totalUsers }}
                        </p>
                    </div>
                    <div
                        class="w-16 h-16 bg-gray-50 dark:bg-[#0a0a0a] rounded-xl flex items-center justify-center border border-gray-200 dark:border-[#3E3E3A]">
                        <span class="text-2xl">👥</span>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-[#161615] p-8 rounded-2xl border border-red-200 dark:border-red-900/40 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-red-600 dark:text-red-400 uppercase tracking-[0.2em] mb-2">
                            Banned Accounts
                        </h3>
                        <p class="text-5xl font-black tracking-tighter text-red-600 dark:text-red-400">
                            {{ $bannedUsers }}
                        </p>
                    </div>
                    <div
                        class="w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center border border-red-200 dark:border-red-900/40">
                        <span class="text-2xl">🚫</span>
                    </div>
                </div>
            </div>

            {{-- Users Table --}}
            <div
                class="bg-white dark:bg-[#161615] rounded-2xl border border-gray-200 dark:border-[#3E3E3A] overflow-hidden">
                <div class="p-8 border-b border-gray-100 dark:border-[#3E3E3A] flex justify-between items-center">
                    <h3 class="font-black text-xl tracking-tighter text-gray-900 dark:text-white">User Directory</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead
                            class="bg-gray-50 dark:bg-[#0a0a0a] text-gray-600 dark:text-gray-300 text-xs font-black uppercase tracking-[0.15em]">
                            <tr>
                                <th scope="col" class="px-8 py-4">User</th>
                                <th scope="col" class="px-8 py-4">Reputation</th>
                                <th scope="col" class="px-8 py-4">Status</th>
                                <th scope="col" class="px-8 py-4 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-[#3E3E3A]">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900 dark:text-white tracking-tight">
                                                {{ $user->name }}
                                            </span>
                                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ $user->email }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-8 py-5">
                                        <span
                                            class="font-black tracking-tighter {{ $user->rep < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                            {{ $user->rep }} Rep
                                        </span>
                                    </td>

                                    <td class="px-8 py-5">
                                        @if ($user->status === 'banned')
                                            <span
                                                class="px-2 py-1 text-xs font-black uppercase tracking-widest rounded bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                Banned
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-black uppercase tracking-widest rounded bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                Active
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-5 text-right">
                                        <form action="{{ route('admin.users.toggle-ban', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to {{ $user->status === 'banned' ? 'unban' : 'ban' }} {{ $user->name }}?');"
                                                class="text-xs font-black uppercase tracking-widest hover:underline px-3 py-1 rounded {{ $user->status === 'banned' ? 'text-green-800 bg-green-100 dark:bg-green-900/30 dark:text-green-300' : 'text-red-800 bg-red-100 dark:bg-red-900/30 dark:text-red-300' }}">
                                                {{ $user->status === 'banned' ? 'Unban' : 'Ban' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="p-6 border-t border-gray-100 dark:border-[#3E3E3A]">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
