<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight tracking-tighter">
            {{ __('Create a Colocation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-gray-200 dark:border-[#3E3E3A] sm:rounded-2xl">
                <div class="p-8 sm:p-12">

                    <div class="mb-8">
                        <h3 class="text-3xl font-black tracking-tighter text-gray-900 dark:text-white mb-2">
                            Set up your new house
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 font-medium">
                            Create a shared workspace to manage expenses, track debts, and organize with your roommates.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('colocation.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                {{ __('Colocation Name') }}
                            </label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" required
                                autofocus placeholder="e.g. The Downtown Apartment"
                                class="block w-full bg-gray-50 dark:bg-[#0a0a0a] border border-gray-200 dark:border-[#3E3E3A] text-gray-900 dark:text-white rounded-xl focus:ring-[#f53003] focus:border-[#f53003] transition-colors py-3 px-4">

                            @error('title')
                                <p class="text-red-600 dark:text-red-400 text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div
                            class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 mt-8 pt-8 border-t border-gray-100 dark:border-[#3E3E3A]">
                            <a href="{{ route('dashboard') }}"
                                class="w-full sm:w-auto text-center px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-bold transition-colors">
                                {{ __('Cancel') }}
                            </a>

                            <button type="submit"
                                class="w-full sm:w-auto text-center bg-[#f53003] hover:bg-[#d42a02] text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-105">
                                {{ __('Create Colocation') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
