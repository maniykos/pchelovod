@extends('admin.layout')
@section('title', 'Изменить фото — Крымский медосбор')
@section('heading', 'Изменить фото')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.gallery.index') }}">← К галерее</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.gallery.update', $galleryItem) }}">@method('PUT')@include('admin.gallery._form', ['submitLabel' => 'Сохранить фото'])</form>@endsection
