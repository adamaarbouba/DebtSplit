<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black dark:text-white leading-tight tracking-tighter">
            {{ __('Log an Expense') }}
        </h2>
        <p class="text-[10px] font-black uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A] mt-1">
            {{ $colocation->title }}
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-[#19140010] dark:border-[#3E3E3A] sm:rounded-2xl">
                <div class="p-8 sm:p-12">

                    <div class="mb-8 border-b border-[#19140010] dark:border-[#3E3E3A] pb-6">
                        <h3 class="text-3xl font-black tracking-tighter text-black dark:text-white mb-2">
                            Add a Bill
                        </h3>
                        <p class="text-[#706f6c] dark:text-[#A1A09A] font-medium text-sm">
                            Enter the total amount paid. The system will split it evenly among the roommates you select.
                        </p>
                    </div>

                    @if ($errors->has('error'))
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl text-sm font-bold">
                            {{ $errors->first('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('expense.store', $colocation->id) }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="category_id"
                                class="block text-xs font-black uppercase tracking-widest text-black dark:text-white mb-2">
                                {{ __('Category') }}
                            </label>
                            <select id="category_id" name="category_id" required
                                class="block w-full bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] text-black dark:text-white rounded-xl focus:ring-[#f53003] focus:border-[#f53003] transition-colors py-3 px-4 font-bold">
                                <option value="" disabled selected>Select what this was for...</option>
                                @foreach ($colocation->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-[#f53003] text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="total_payment"
                                class="block text-xs font-black uppercase tracking-widest text-black dark:text-white mb-2">
                                {{ __('Total Payment Amount (DH)') }}
                            </label>
                            <div class="relative">
                                <input id="total_payment" type="number" step="0.01" name="total_payment"
                                    value="{{ old('total_payment') }}" required placeholder="e.g. 500.00"
                                    class="block w-full bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] text-black dark:text-white rounded-xl focus:ring-[#f53003] focus:border-[#f53003] transition-colors py-4 px-4 text-2xl font-black tracking-tighter">
                                <span
                                    class="absolute right-4 top-1/2 -translate-y-1/2 font-black text-[#706f6c] dark:text-[#A1A09A]">DH</span>
                            </div>
                            @error('total_payment')
                                <p class="text-[#f53003] text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 border-t border-[#19140010] dark:border-[#3E3E3A]">
                            <label
                                class="block text-xs font-black uppercase tracking-widest text-black dark:text-white mb-4">
                                {{ __('Split this bill with:') }}
                            </label>
                            <div class="space-y-3">
                                @foreach ($colocation->users as $roommate)
                                    <label
                                        class="flex items-center p-4 bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] rounded-xl cursor-pointer hover:border-[#f53003]/30 transition">
                                        <input type="checkbox" name="split_with[]" value="{{ $roommate->id }}" checked
                                            class="w-5 h-5 rounded border-[#19140020] dark:border-[#3E3E3A] text-[#f53003] focus:ring-[#f53003]">
                                        <div class="ml-4 flex flex-col">
                                            <span
                                                class="font-bold text-black dark:text-white tracking-tight">{{ $roommate->name }}</span>
                                            <span
                                                class="text-[10px] font-black uppercase tracking-widest text-[#706f6c]">
                                                {{ $roommate->id === auth()->id() ? '(You)' : $roommate->pivot->role }}
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('split_with')
                                <p class="text-[#f53003] text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div
                            class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 mt-8 pt-8 border-t border-[#19140010] dark:border-[#3E3E3A]">
                            <a href="{{ route('colocation.show', $colocation->id) }}"
                                class="w-full sm:w-auto text-center px-6 py-3 text-[#706f6c] dark:text-[#A1A09A] hover:text-black dark:hover:text-white font-bold transition-colors">
                                {{ __('Cancel') }}
                            </a>

                            <button type="submit"
                                class="w-full sm:w-auto text-center bg-[#f53003] hover:bg-[#d42a02] text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-105">
                                {{ __('Save & Split Bill') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
