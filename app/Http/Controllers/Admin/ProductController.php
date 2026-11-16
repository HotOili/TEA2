<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Tovar};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Tovar::with('categoryRel')->orderByDesc('id')->get();
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        return view('admin.product_form', [
            'product'    => new Tovar(['year' => date('Y'), 'is_published' => 1]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function edit(int $id)
    {
        $product    = Tovar::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.product_form', compact('product', 'categories'));
    }

    public function store(Request $r)          { return $this->save($r, null); }
    public function update(Request $r, int $id){ return $this->save($r, $id); }

    protected function save(Request $r, ?int $id)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:200',
            'price'       => 'required|integer|min:1',
            'category'    => 'required|exists:category,id',
            'country'     => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:1990|max:2100',
            'model'       => 'nullable|string|max:100',
            'nalichie'    => 'required|integer|min:0',
            'discription' => 'nullable|string',
            'img'         => 'nullable|string|max:255',
            'img_file'    => 'nullable|image|max:4096',
        ], [], [
            'name' => 'наименование', 'price' => 'цена',
            'category' => 'категория', 'nalichie' => 'наличие',
        ]);

        if ($r->hasFile('img_file')) {
            $path = $r->file('img_file')->store('img', 'public_uploads');
            $data['img'] = '/public/' . $path;
        }

        $data['is_published'] = $r->boolean('is_published');
        $data['year']    = $data['year']    ?? 0;
        $data['model']   = $data['model']   ?? '';
        $data['country'] = $data['country'] ?? '';
        $data['img']     = $data['img']     ?? '';

        if ($id) {
            Tovar::findOrFail($id)->update($data);
            $msg = 'Товар обновлён';
        } else {
            $data['created_at'] = now();
            Tovar::create($data);
            $msg = 'Товар добавлен';
        }

        return redirect()->route('admin.products')->with('success', $msg);
    }

    /** Страница подтверждения удаления (GET) */
    public function confirmDelete(int $id)
    {
        $product = Tovar::findOrFail($id);
        return view('admin.product_delete', compact('product'));
    }

    /** Само удаление (POST) */
    public function destroy(int $id)
    {
        Tovar::findOrFail($id)->delete();
        return redirect()->route('admin.products')->with('success', 'Товар удалён');
    }
}