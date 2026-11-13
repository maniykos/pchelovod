<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blog.index', ['posts' => BlogPost::latest('published_at')->get()]);
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        BlogPost::create($this->validated($request, true));

        return redirect()->route('admin.blog.index')->with('success', 'Статья добавлена.');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $post->update($this->validated($request, false, $post));

        return redirect()->route('admin.blog.index')->with('success', 'Статья обновлена.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();

        return back()->with('success', 'Статья удалена.');
    }

    private function validated(Request $request, bool $requiredImage = false, ?BlogPost $post = null): array
    {
        $data = $request->validate([
            'title_ru' => ['required', 'string', 'max:180'], 'title_en' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180'], 'excerpt_ru' => ['required', 'string'], 'excerpt_en' => ['required', 'string'],
            'body_ru' => ['required', 'string'], 'body_en' => ['required', 'string'],
            'published_at' => ['nullable', 'date'], 'is_published' => ['nullable', 'boolean'], 'image' => [$requiredImage ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            if ($post?->image && str_starts_with($post->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->image));
            }
            $data['image'] = Storage::disk('public')->url($request->file('image')->store('blog', 'public'));
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
