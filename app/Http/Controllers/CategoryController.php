<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, Category $category = null)
    {

        $categories = Category::latest()->paginate(5);

        return view('admin.pages.category.index', compact('categories', 'category'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->only('name'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
