@extends('layouts.app')
@section('title', 'Галерея — Крымский медосбор')
@section('content')
<section class="page-hero"><div class="container"><p class="eyebrow">{{ app()->getLocale() === 'ru' ? 'Из жизни пасеки' : 'From the apiary' }}</p><h1>{{ app()->getLocale() === 'ru' ? 'Там, где рождается вкус' : 'Where flavour begins' }}</h1><p>{{ app()->getLocale() === 'ru' ? 'Фото и видео с нашей пасеки — ульи, пчёлы и медосбор.' : 'Photos and videos from our apiary — hives, bees and the honey harvest.' }}</p></div></section>
<section class="section-pad gallery-page-section">
    <div class="container"><div class="gallery-grid">
        @foreach($gallery as $index => $item)
            <figure class="gallery-item gallery-item-{{ ($index % 5) + 1 }} {{ $item->media_type === 'video' ? 'gallery-item-video' : '' }}">
                @if($item->media_type === 'video')
                    <video controls playsinline preload="metadata" aria-label="{{ $item->{'title_'.app()->getLocale()} ?: $item->title_ru }}">
                        <source src="{{ $item->image }}" type="{{ $item->mime_type ?: 'video/mp4' }}">
                        <a href="{{ $item->image }}">{{ app()->getLocale() === 'ru' ? 'Скачать видео' : 'Download video' }}</a>
                    </video>
                @else
                    <a class="gallery-photo" href="{{ $item->image }}" data-gallery-photo data-title="{{ $item->{'title_'.app()->getLocale()} ?: $item->title_ru }}" aria-label="{{ app()->getLocale() === 'ru' ? 'Увеличить фото: ' : 'Enlarge photo: ' }}{{ $item->{'title_'.app()->getLocale()} ?: $item->title_ru }}">
                        <img src="{{ $item->image }}" alt="{{ $item->{'alt_'.app()->getLocale()} ?: $item->alt_ru }}" loading="lazy">
                    </a>
                @endif
                <figcaption>{{ $item->{'title_'.app()->getLocale()} ?: $item->title_ru }}</figcaption>
            </figure>
        @endforeach
    </div></div>
</section>
@endsection
