<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\ContactSetting;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        return view('admin.content', [
            'contacts' => ContactSetting::first() ?? new ContactSetting,
            'posts' => BlogPost::latest('published_at')->get(),
            'certificates' => Certificate::orderBy('sort_order')->get(),
            'gallery' => GalleryItem::orderBy('sort_order')->get(),
        ]);
    }

    public function updateContacts(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:40'],
            'telegram' => ['required', 'string', 'max:80'],
            'max_username' => ['required', 'string', 'max:80'],
            'email' => ['nullable', 'email'],
            'address_ru' => ['required', 'string', 'max:180'],
            'address_en' => ['required', 'string', 'max:180'],
        ]);
        ContactSetting::updateOrCreate([], $data);

        return back()->with('success', 'Контакты сохранены.');
    }

    public function storePost(Request $request)
    {
        BlogPost::create($this->postData($request));

        return back()->with('success', 'Статья добавлена.');
    }

    public function updatePost(Request $request, BlogPost $post)
    {
        $post->update($this->postData($request));

        return back()->with('success', 'Статья обновлена.');
    }

    public function destroyPost(BlogPost $post)
    {
        $post->delete();

        return back()->with('success', 'Статья удалена.');
    }

    public function storeCertificate(Request $request)
    {
        Certificate::create($request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'], 'issuer' => ['required', 'string'],
            'year' => ['required', 'integer'], 'image' => ['required', 'url'], 'description_ru' => ['nullable', 'string'], 'description_en' => ['nullable', 'string'],
        ]));

        return back()->with('success', 'Сертификат добавлен.');
    }

    public function destroyCertificate(Certificate $certificate)
    {
        $certificate->delete();

        return back()->with('success', 'Сертификат удалён.');
    }

    public function updateCertificate(Request $request, Certificate $certificate)
    {
        $certificate->update($request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'], 'issuer' => ['required', 'string'],
            'year' => ['required', 'integer'], 'image' => ['required', 'url'], 'description_ru' => ['nullable', 'string'], 'description_en' => ['nullable', 'string'],
        ]));

        return back()->with('success', 'Сертификат обновлён.');
    }

    public function storeGallery(Request $request)
    {
        GalleryItem::create($request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'], 'image' => ['required', 'url'],
            'alt_ru' => ['nullable', 'string'], 'alt_en' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'],
        ]) + ['is_published' => true]);

        return back()->with('success', 'Изображение добавлено.');
    }

    public function destroyGallery(GalleryItem $galleryItem)
    {
        $galleryItem->delete();

        return back()->with('success', 'Изображение удалено.');
    }

    public function updateGallery(Request $request, GalleryItem $galleryItem)
    {
        $galleryItem->update($request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'], 'image' => ['required', 'url'],
            'alt_ru' => ['nullable', 'string'], 'alt_en' => ['nullable', 'string'], 'sort_order' => ['nullable', 'integer'],
            'is_published' => ['nullable', 'boolean'],
        ]));

        return back()->with('success', 'Фото галереи обновлено.');
    }

    private function postData(Request $request): array
    {
        return $request->validate([
            'title_ru' => ['required', 'string', 'max:180'], 'title_en' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180'], 'excerpt_ru' => ['required', 'string'], 'excerpt_en' => ['required', 'string'],
            'body_ru' => ['required', 'string'], 'body_en' => ['required', 'string'], 'image' => ['required', 'url'],
            'published_at' => ['nullable', 'date'], 'is_published' => ['nullable', 'boolean'],
        ]);
    }
}
