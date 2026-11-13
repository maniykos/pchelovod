@extends('admin.layout')
@section('title', 'Изменить товар — Honey Atelier')
@section('heading', 'Изменить товар')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.products.index') }}">← К списку товаров</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.products.update', $product) }}">@method('PUT')@include('admin.products._form', ['submitLabel' => 'Сохранить изменения'])</form>@endsection
