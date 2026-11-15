@extends('admin.layout')
@section('title', 'Новый сертификат — Крымский медосбор')
@section('heading', 'Новый сертификат')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.certificates.index') }}">← К списку сертификатов</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.certificates.store') }}">@include('admin.certificates._form', ['submitLabel' => 'Добавить сертификат'])</form>@endsection
