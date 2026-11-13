<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use App\Models\OrderRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index', ['contacts' => ContactSetting::first()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:1000'],
            'product_id' => ['nullable', 'string'],
            'product_title' => ['nullable', 'string', 'max:160'],
        ]);

        OrderRequest::create($data + ['locale' => $this->locale(), 'status' => 'new']);

        return back()->with('success', $this->locale() === 'ru' ? 'Спасибо! Мы свяжемся с вами в ближайшее время.' : 'Thank you! We will contact you shortly.');
    }
}
