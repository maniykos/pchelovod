@extends('admin.layout')
@section('title', 'Изменить статью — Honey Atelier')
@section('heading', 'Изменить статью')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.blog.index') }}">← К списку статей</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.blog.update', $post) }}">@method('PUT')@include('admin.blog._form', ['submitLabel' => 'Сохранить статью'])</form>@endsection
