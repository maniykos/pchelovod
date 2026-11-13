<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        return view('admin.certificates.index', ['certificates' => Certificate::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        Certificate::create($this->validated($request, true));

        return redirect()->route('admin.certificates.index')->with('success', 'Сертификат добавлен.');
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $certificate->update($this->validated($request, false, $certificate));

        return redirect()->route('admin.certificates.index')->with('success', 'Сертификат обновлён.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return back()->with('success', 'Сертификат удалён.');
    }

    private function validated(Request $request, bool $requiredImage = false, ?Certificate $certificate = null): array
    {
        $data = $request->validate([
            'title_ru' => ['required', 'string'], 'title_en' => ['required', 'string'], 'issuer' => ['required', 'string'],
            'year' => ['required', 'integer'], 'image' => [$requiredImage ? 'required' : 'nullable', 'image', 'max:5120'], 'description_ru' => ['nullable', 'string'], 'description_en' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('image')) {
            if ($certificate?->image && str_starts_with($certificate->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $certificate->image));
            }
            $data['image'] = Storage::disk('public')->url($request->file('image')->store('certificates', 'public'));
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
