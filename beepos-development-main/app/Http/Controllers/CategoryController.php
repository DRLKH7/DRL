<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menus')->orderBy('name')->get();

        return view('admin.kategori', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category = new Category;
        $category->name = $data['name'];
        $category->description = $data['description'] ?? null;
        $category->save();

        return response()->json(['success' => true, 'id' => $category->id]);
    }

    public function update(Request $request, Category $kategori)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $kategori->name = $data['name'];
        $kategori->description = $data['description'] ?? null;
        $kategori->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Category $kategori)
    {
        $kategori->delete();

        return response()->json(['success' => true]);
    }
}
