<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $colocation->title }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500 font-mono bg-gray-100 px-2 py-1 rounded">Code: {{ $colocation->token }}</span>
                <span class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ $colocation->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $colocation->status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">My Balance</h3>
                        <p class="mt-2 text-4xl font-black {{ $colocation->pivot->debt > 0 ? 'text-red-500' : 'text-green-500' }}">
                            {{ number_format($colocation->pivot->debt, 2) }} <span class="text-lg">DH</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-4">Member since {{ \Carbon\Carbon::parse($colocation->pivot->joined_at)->format('M Y') }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Expense Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($colocation->categories as $category)
                                <span class="px-3 py-1 rounded-lg text-sm font-medium text-white" style="background-color: {{ $category->color ?? '#6366f1' }}">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Current Roommates</h3>
                            <button class="text-xs font-bold text-indigo-600 hover:underline">+ Invite Someone</button>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-400 text-xs uppercase">
                                    <tr>
                                        <th class="px-6 py-3">Member</th>
                                        <th class="px-6 py-3">Role</th>
                                        <th class="px-6 py-3 text-right">Current Debt</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($colocation->users as $roommate)
                                        <tr class="{{ $roommate->id === auth()->id() ? 'bg-indigo-50/30' : '' }}">
                                            <td class="px-6 py-4 flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600 text-xs">
                                                    {{ strtoupper(substr($roommate->name, 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-gray-900">
                                                    {{ $roommate->name }} 
                                                    {!! $roommate->id === auth()->id() ? '<span class="text-[10px] bg-indigo-200 px-1 rounded text-indigo-700 ml-1">YOU</span>' : '' !!}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 italic">{{ $roommate->pivot->role }}</td>
                                            <td class="px-6 py-4 text-right font-bold {{ $roommate->pivot->debt > 0 ? 'text-red-500' : 'text-gray-400' }}">
                                                {{ number_format($roommate->pivot->debt, 2) }} DH
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