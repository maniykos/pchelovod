<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.gallery.index', ['gallery' => GalleryItem::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        GalleryItem::create($this->validated($request, true) + ['is_published' => $request->boolean('is_published', true)]);

        return redirect()->route('admin.gallery.index')->with('success', 'Фото добавлено.');
    }

    public function edit(GalleryItem $galleryItem)
    {
        return view('admin.gallery.edit', compact('galleryItem'));
    }

    public function update(Request $request, GalleryItem $galleryItem)
    {
        $galleryItem->update($this->validated($request, false, $galleryItem) + ['is_published' => $request->boolean('is_published')]);

        return redirect()->route('admin.gallery.index')->with('success', 'Фото обновлено.');
    }

    public function destroy(GalleryItem $galleryItem)
    {
        $galleryItem->delete();

        return back()->with('success', 'Фото удалено.');
    }

    private function validated(Request $request, bool $requiredImage = false, ?GalleryItem $galleryItem = null): array
    {
        $data = $request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'], 'image' => [$requiredImage ? 'required' : 'nullable', 'image', 'max:5120'],
            'alt_ru' => ['nullable', 'string'], 'alt_en' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            if ($galleryItem?->image && str_starts_with($galleryItem->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $galleryItem->image));
            }
            $data['image'] = Storage::disk('public')->url($request->file('image')->store('gallery', 'public'));
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
