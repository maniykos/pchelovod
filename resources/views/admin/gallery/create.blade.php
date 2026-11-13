@extends('admin.layout')
@section('title', 'Новое фото — Honey Atelier')
@section('heading', 'Новое фото')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.gallery.index') }}">← К галерее</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.gallery.store') }}">@include('admin.gallery._form', ['submitLabel' => 'Добавить фото'])</form>@endsection
