<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view('admin.products', ['products' => Product::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        Product::create($this->validated($request, true));

        return back()->with('success', 'Товар добавлен.');
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, false, $product));

        return back()->with('success', 'Товар обновлён.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Товар удалён.');
    }

    private function validated(Request $request, bool $requiredImage = false, ?Product $product = null): array
    {
        $data = $request->validate([
            'title_ru' => ['required', 'string', 'max:160'],
            'title_en' => ['required', 'string', 'max:160'],
            'description_ru' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:40'],
            'image' => [$requiredImage ? 'required' : 'nullable', 'image', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($product?->image && str_starts_with($product->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
            }
            $data['image'] = Storage::disk('public')->url($request->file('image')->store('products', 'public'));
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
