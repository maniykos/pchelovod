<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        return view('certificates.index', ['certificates' => Certificate::orderBy('sort_order')->get()]);
    }
}
