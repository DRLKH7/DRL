<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.menu', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ]);

        $menu = new Menu;
        $menu->name = $data['name'];
        $menu->category_id = $data['category_id'];
        $menu->description = $data['description'] ?? null;
        $menu->price = $data['price'];
        $menu->stock = 0;
        $menu->status = $data['status'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $menu->image_path = $path;
        }

        $menu->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $menu->id]);
        }

        return back()->with('success', 'Menu berhasil ditambahkan');
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ]);

        $menu->name = $data['name'];
        $menu->category_id = $data['category_id'];
        $menu->description = $data['description'] ?? null;
        $menu->price = $data['price'];
        $menu->status = $data['status'];

        if ($request->hasFile('image')) {
            if ($menu->image_path && Storage::disk('public')->exists($menu->image_path)) {
                Storage::disk('public')->delete($menu->image_path);
            }
            $path = $request->file('image')->store('menus', 'public');
            $menu->image_path = $path;
        }

        $menu->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image_path && Storage::disk('public')->exists($menu->image_path)) {
            Storage::disk('public')->delete($menu->image_path);
        }
        $menu->delete();

        return response()->json(['success' => true]);
    }
}
