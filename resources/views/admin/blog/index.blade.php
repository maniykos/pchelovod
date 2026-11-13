@extends('admin.layout')
@section('title', 'Блог — Honey Atelier')
@section('heading', 'Блог')
@section('content')
<div class="admin-page-toolbar"><div><p>Создавайте статьи на русском и английском, управляйте публикацией и изображением.</p></div><a class="button button-dark" href="{{ route('admin.blog.create') }}">+ Новая статья</a></div>
<div class="admin-table"><div class="admin-table-head"><span>Статья</span><span>Дата</span><span>Статус</span><span>Действия</span></div>@forelse($posts as $post)<div class="admin-table-row"><div class="admin-product-cell"><img src="{{ $post->image }}" alt=""><div><strong>{{ $post->title_ru }}</strong><small>/blog/{{ $post->slug }}</small></div></div><span>{{ optional($post->published_at)->format('d.m.Y') }}</span><span class="status-pill {{ $post->is_published ? 'status-live' : 'status-draft' }}">{{ $post->is_published ? 'Опубликована' : 'Черновик' }}</span><div class="admin-row-actions"><a class="text-link" href="{{ route('admin.blog.edit', $post) }}">Изменить</a><form method="post" action="{{ route('admin.blog.destroy', $post) }}">@csrf @method('DELETE')<button class="icon-button" type="submit">×</button></form></div></div>@empty<div class="admin-empty">Статей пока нет.</div>@endforelse</div>
@endsection
