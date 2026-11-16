<?php
namespace App\Http\Controllers;

use App\Models\{Category, Tovar};

class PageController extends Controller
{
    public function about()
    {
        $novelties = Tovar::available()
            ->orderByDesc('created_at')->orderByDesc('id')
            ->limit(5)->get();

        return view('pages.about', compact('novelties'));
    }

    public function catalog(\Illuminate\Http\Request $r)
    {
        $categories = Category::orderBy('name')->get();

        $catId = (int)$r->input('cat', 0);
        $sort  = (string)$r->input('sort', 'new');

        $orderMap = [
            'new'        => ['created_at','desc'],
            'price_asc'  => ['price','asc'],
            'price_desc' => ['price','desc'],
            'name_asc'   => ['name','asc'],
            'name_desc'  => ['name','desc'],
            'year_desc'  => ['year','desc'],
            'year_asc'   => ['year','asc'],
        ];
        [$col, $dir] = $orderMap[$sort] ?? $orderMap['new'];

        $q = Tovar::available()->with('categoryRel')->orderBy($col, $dir);
        if ($catId) $q->where('category', $catId);

        $products = $q->get();

        return view('pages.catalog', compact('products','categories','catId','sort'));
    }

    public function product(int $id)
    {
        $product = Tovar::with('categoryRel')
            ->where('is_published', 1)
            ->findOrFail($id);

        return view('pages.product', compact('product'));
    }

    public function contacts()
    {
        return view('pages.contacts');
    }
}