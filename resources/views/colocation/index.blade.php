<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Colocations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($colocations as $colocation)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 flex flex-col">
                        <div class="p-6 flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="font-bold text-xl text-gray-900">{{ $colocation->title }}</h4>
                                <span class="px-2 py-1 text-xs font-bold rounded {{ $colocation->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ strtoupper($colocation->status) }}
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 space-y-2">
                                <p>👥 {{ $colocation->users_count }} Roommates</p>
                                <p>💰 Your Debt: 
                                    <span class="font-bold {{ $colocation->pivot->debt > 0 ? 'text-red-500' : 'text-green-500' }}">
                                        {{ number_format($colocation->pivot->debt, 2) }} DH
                                    </span>
                                </p>
                            </div>
                        </div>

                        {{-- Action Area --}}
                        <div class="bg-gray-50 p-4 border-t border-gray-100">
                            @if ($colocation->status === 'active')
                                {{-- Only show the link if active --}}
                                <a href="{{ route('colocation.show', $colocation->id) }}"
                                    class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                                    {{ __('View Details') }}
                                </a>
                            @else
                                {{-- Show a disabled state for non-active --}}
                                <button disabled class="block w-full text-center bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed">
                                    Access Restricted
                                </button>
                                <p class="text-[10px] text-center text-gray-400 mt-2 italic">
                                    This colocation is currently {{ $colocation->status }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 rounded-lg text-center shadow">
                        <p class="text-gray-500 italic">You haven't joined any colocations yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>