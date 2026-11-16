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
        $data = $this->validated($request, true);
        try {
            GalleryItem::create($data + ['is_published' => $request->boolean('is_published', true)]);
        } catch (\Throwable $exception) {
            $this->deleteUpload($data['image']);
            throw $exception;
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Файл добавлен в галерею.');
    }

    public function edit(GalleryItem $galleryItem)
    {
        return view('admin.gallery.edit', compact('galleryItem'));
    }

    public function update(Request $request, GalleryItem $galleryItem)
    {
        $data = $this->validated($request);
        $previous = $galleryItem->image;
        try {
            $galleryItem->update($data + ['is_published' => $request->boolean('is_published')]);
        } catch (\Throwable $exception) {
            if (isset($data['image'])) {
                $this->deleteUpload($data['image']);
            }
            throw $exception;
        }
        if (isset($data['image'])) {
            $this->deleteUpload($previous);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Файл галереи обновлён.');
    }

    public function destroy(GalleryItem $galleryItem)
    {
        $path = $galleryItem->image;
        $galleryItem->delete();

        $this->deleteUpload($path);

        return back()->with('success', 'Файл удалён из галереи.');
    }

    private function validated(Request $request, bool $requiredImage = false): array
    {
        $data = $request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'],
            'image' => [$requiredImage ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm', 'max:102400'],
            'alt_ru' => ['nullable', 'string'], 'alt_en' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'],
        ], [
            'image.required' => 'Выберите фотографию или видео.',
            'image.mimes' => 'Допустимы JPG, PNG, WebP, GIF, MP4 и WebM.',
            'image.max' => 'Размер файла не должен превышать 100 МБ.',
        ]);

        if ($request->hasFile('image')) {
            $upload = $request->file('image');
            $path = $upload->store('gallery', 'public');
            if (! $path) {
                throw new \RuntimeException('Не удалось сохранить файл галереи.');
            }
            $data['image'] = '/storage/'.$path;
            $data['mime_type'] = $upload->getMimeType();
            $data['media_type'] = str_starts_with($data['mime_type'], 'video/') ? 'video' : 'image';
        } else {
            unset($data['image']);
        }

        return $data;
    }

    private function deleteUpload(?string $url): void
    {
        $path = parse_url($url ?? '', PHP_URL_PATH) ?: '';
        if (str_starts_with($path, '/storage/gallery/')) {
            Storage::disk('public')->delete(substr($path, strlen('/storage/')));
        }
    }
}
