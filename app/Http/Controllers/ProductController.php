<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', ['products' => Product::where('is_published', true)->orderBy('sort_order')->paginate(12)]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_published, 404);

        return view('products.show', compact('product'));
    }
}
