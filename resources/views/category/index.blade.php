<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('colocation.show', $colocation->id) }}"
                class="text-[10px] font-black uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A] hover:text-[#f53003] transition mb-2 inline-block">
                &larr; Back to {{ $colocation->title }}
            </a>
            <h2 class="font-bold text-2xl text-black dark:text-white leading-tight tracking-tighter">
                {{ __('Manage Categories') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Form to Add New Category --}}
            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-[#19140010] dark:border-[#3E3E3A] sm:rounded-2xl p-8">
                <h3 class="text-lg font-black tracking-tight text-black dark:text-white mb-6">Create New Category</h3>

                <form action="{{ route('category.store', $colocation->id) }}" method="POST"
                    class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @csrf
                    <div class="w-full sm:flex-1">
                        <input type="text" name="name" required placeholder="e.g. Utilities, Groceries..."
                            class="w-full bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] text-black dark:text-white rounded-xl focus:ring-[#f53003] focus:border-[#f53003] transition-colors py-3 px-4 font-bold placeholder-[#706f6c]">
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <div
                            class="flex items-center gap-2 bg-gray-50 dark:bg-[#0a0a0a] border border-[#19140010] dark:border-[#3E3E3A] rounded-xl px-3 py-2">
                            <span class="text-xs font-black text-[#706f6c] uppercase tracking-widest">Color:</span>
                            <input type="color" name="color" required value="#f53003"
                                class="p-0 border-0 rounded-lg w-8 h-8 cursor-pointer bg-transparent overflow-hidden">
                        </div>

                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-black dark:bg-white text-white dark:text-black hover:bg-[#f53003] dark:hover:bg-[#f53003] hover:text-white dark:hover:text-white rounded-xl text-xs font-bold transition">
                            + Add
                        </button>
                    </div>
                </form>
            </div>

            {{-- List of Current Categories --}}
            <div
                class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm border border-[#19140010] dark:border-[#3E3E3A] sm:rounded-2xl">
                <div class="p-8 border-b border-gray-50 dark:border-[#3E3E3A]">
                    <h3 class="font-black text-xl tracking-tighter dark:text-white">Existing Categories</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead
                            class="bg-gray-50/50 dark:bg-[#0a0a0a] text-[#706f6c] text-[10px] font-black uppercase tracking-[0.15em]">
                            <tr>
                                <th class="px-8 py-4">Category Preview</th>
                                <th class="px-8 py-4">Expenses Logged</th>
                                <th class="px-8 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-[#3E3E3A]">
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-8 py-5">
                                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-white shadow-sm"
                                            style="background-color: {{ $category->color }}">
                                            {{ $category->name }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-xs font-bold text-[#706f6c]">
                                        {{ $category->expenses_count }} Bills
                                    </td>
                                    <td class="px-8 py-5 text-right space-x-3">
                                        <a href="{{ route('category.edit', ['colocation' => $colocation->id, 'category' => $category->id]) }}"
                                            class="text-[10px] font-black text-black dark:text-white uppercase tracking-widest hover:text-[#f53003] dark:hover:text-[#f53003]">
                                            Edit
                                        </a>

                                        @if ($category->expenses_count === 0)
                                            <form
                                                action="{{ route('category.destroy', ['colocation' => $colocation->id, 'category' => $category->id]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Delete this category?');"
                                                    class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span
                                                class="text-[9px] font-black text-[#706f6c] uppercase tracking-widest cursor-not-allowed"
                                                title="Cannot delete category in use">Locked</span>
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
</x-app-layout>
