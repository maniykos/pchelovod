<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ContactSetting;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'products' => Product::where('is_published', true)->orderBy('sort_order')->limit(5)->get(),
            'posts' => BlogPost::where('is_published', true)->latest('published_at')->limit(3)->get(),
            'contacts' => ContactSetting::first(),
            'locale' => $this->locale(),
        ]);
    }
}
