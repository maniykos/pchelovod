@extends('admin.layout')
@section('title', 'Изменить сертификат — Honey Atelier')
@section('heading', 'Изменить сертификат')
@section('content')<div class="admin-page-toolbar"><a class="text-link" href="{{ route('admin.certificates.index') }}">← К списку сертификатов</a></div><form class="admin-form admin-form-page" enctype="multipart/form-data" method="post" action="{{ route('admin.certificates.update', $certificate) }}">@method('PUT')@include('admin.certificates._form', ['submitLabel' => 'Сохранить сертификат'])</form>@endsection
