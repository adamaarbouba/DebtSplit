<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black dark:text-white leading-tight tracking-tighter">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-[#19140010] dark:border-[#3E3E3A] sm:rounded-2xl p-8">

                <form
                    action="{{ route('category.update', ['colocation' => $colocation->id, 'category' => $category->id]) }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-black dark:text-white mb-2">Category
                            Name</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] text-black dark:text-white rounded-xl focus:ring-[#f53003] focus:border-[#f53003] transition-colors py-3 px-4 font-bold">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-black dark:text-white mb-2">Tag
                            Color</label>
                        <input type="color" name="color" value="{{ old('color', $category->color) }}" required
                            class="p-0 border border-[#19140010] dark:border-[#3E3E3A] rounded-lg w-16 h-16 cursor-pointer bg-transparent overflow-hidden">
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-[#19140010] dark:border-[#3E3E3A]">
                        <a href="{{ route('category.index', $colocation->id) }}"
                            class="px-6 py-3 text-[#706f6c] dark:text-[#A1A09A] hover:text-black dark:hover:text-white font-bold transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-[#f53003] hover:bg-[#d42a02] text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-105">
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
