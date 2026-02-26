<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <span>{{ __('Welcome ') . auth()->user()->name }}</span>

                        <a href="{{ route('colocation.index') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            {{ __('Colocations History') }}
                        </a>
                    </div>
                </div>
                <div class="p-6 text-gray-900">

                    @if ($activeColocation)
                        <a href="{{ route('colocation.show', $activeColocation->id) }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Current Colocation') }}
                        </a>
                    @else
                        <p class="text-gray-500 italic">No active colocation found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
