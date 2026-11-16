<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\ContactSetting;
use App\Models\GalleryItem;
use App\Models\OrderRequest;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'Товары', 'value' => Product::count(), 'icon' => 'jar'],
                ['label' => 'Статьи', 'value' => BlogPost::count(), 'icon' => 'book-open'],
                ['label' => 'Фото и видео', 'value' => GalleryItem::count(), 'icon' => 'images'],
                ['label' => 'Заявки', 'value' => OrderRequest::where('status', 'new')->count(), 'icon' => 'inbox'],
            ],
            'contacts' => ContactSetting::first(),
            'certificates' => Certificate::count(),
        ]);
    }
}
