@extends('admin.layout')
@section('title', 'Новая статья — Honey Atelier')
@section('heading', 'Новая статья')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.blog.index') }}">← К списку статей</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.blog.store') }}">@include('admin.blog._form', ['submitLabel' => 'Опубликовать статью'])</form>@endsection
