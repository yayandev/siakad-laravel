<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(5);
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        if (!$category) {
            return redirect('/categories')->with(['error' => 'Category not created!']);
        }

        return redirect('/categories')->with(['success' => 'Category created!']);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect('/categories')->with(['error' => 'Category not found!']);
        }
        $category->delete();
        return redirect('/categories')->with(['success' => 'Category deleted successfully!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return redirect('/categories')->with(['error' => 'Category not found!']);
        }

        $category->update([
            'name' => $request->name
        ]);

        return redirect('/categories')->with(['success' => 'Category updated successfully!']);
    }
}
