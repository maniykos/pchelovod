<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function edit()
    {
        return view('admin.contacts.edit', ['contacts' => ContactSetting::first() ?? new ContactSetting]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:40'], 'telegram' => ['required', 'string', 'max:80'],
            'max_username' => ['required', 'string', 'max:80'], 'email' => ['nullable', 'email'],
            'address_ru' => ['required', 'string', 'max:180'], 'address_en' => ['required', 'string', 'max:180'],
            'working_hours_ru' => ['nullable', 'string', 'max:120'], 'working_hours_en' => ['nullable', 'string', 'max:120'],
        ]);
        ContactSetting::updateOrCreate([], $data);

        return back()->with('success', 'Контакты сохранены.');
    }
}
