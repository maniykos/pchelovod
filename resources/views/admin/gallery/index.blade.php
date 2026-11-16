@extends('admin.layout')
@section('title', 'Галерея — Крымский медосбор')
@section('heading', 'Галерея')
@section('content')
<div class="admin-page-toolbar"><div><p>Фотографии и видео на странице галереи.</p></div><a class="button button-dark" href="{{ route('admin.gallery.create') }}">+ Добавить фото или видео</a></div>
<div class="admin-gallery-grid">
    @forelse($gallery as $item)
        <article class="admin-gallery-card">
            @if($item->media_type === 'video')
                <video controls playsinline preload="metadata" aria-label="{{ $item->title_ru }}"><source src="{{ $item->image }}" type="{{ $item->mime_type ?: 'video/mp4' }}"></video>
            @else
                <img src="{{ $item->image }}" alt="{{ $item->alt_ru }}" loading="lazy">
            @endif
            <div><strong>{{ $item->title_ru }}</strong><small>{{ $item->media_type === 'video' ? 'Видео' : 'Фото' }} · {{ $item->is_published ? 'Опубликовано' : 'Скрыто' }} · порядок {{ $item->sort_order }}</small><div class="admin-row-actions"><a class="text-link" href="{{ route('admin.gallery.edit', $item) }}">Изменить</a><form method="post" action="{{ route('admin.gallery.destroy', $item) }}">@csrf @method('DELETE')<button class="icon-button" type="submit" aria-label="Удалить {{ $item->title_ru }}">×</button></form></div></div>
        </article>
    @empty
        <div class="admin-empty">Фотографий и видео пока нет.</div>
    @endforelse
</div>
@endsection
