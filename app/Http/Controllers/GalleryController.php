<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        return view('gallery.index', [
            'gallery' => GalleryItem::where('is_published', true)->orderBy('sort_order')->get(),
        ]);
    }
}
