<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Http\Requests\IndexCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Colocation;

class CategoryController extends Controller
{
    public function index(IndexCategoryRequest $request, Colocation $colocation)
    {
        $categories = $colocation->categories()->withCount('expenses')->get();

        return view('category.index', compact('colocation', 'categories'));
    }

    public function store(StoreCategoryRequest $request, Colocation $colocation)
    {
        $colocation->categories()->create($request->validated());

        return back()->with('success', 'Category created successfully!');
    }

    public function edit(EditCategoryRequest $request, Colocation $colocation, Category $category)
    {
        return view('category.edit', compact('colocation', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Colocation $colocation, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('category.index', $colocation->id)->with('success', 'Category updated!');
    }

    public function destroy(DestroyCategoryRequest $request, Colocation $colocation, Category $category)
    {
        if ($category->expenses()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete a category that has expenses attached to it!']);
        }

        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
