@extends('admin.layout')
@section('title', 'Новый товар — Honey Atelier')
@section('heading', 'Новый товар')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.products.index') }}">← К списку товаров</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.products.store') }}">@include('admin.products._form', ['submitLabel' => 'Создать товар'])</form>@endsection
