<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Tovar};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tovars')->orderBy('name')->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $r)
    {
        $data = $r->validate(
            ['name' => 'required|string|max:100|unique:category,name'],
            [],
            ['name' => 'название']
        );

        Category::create($data);

        return back()->with('success', 'Категория добавлена');
    }

    public function confirmDelete(int $id)
    {
        $category = Category::withCount('tovars')->findOrFail($id);
        return view('admin.category_delete', compact('category'));
    }

    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);

        if (Tovar::where('category', $id)->exists()) {
            return back()->withErrors([
                'Нельзя удалить категорию: в ней есть товары',
            ]);
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Категория удалена');
    }
}