@extends('layouts.app')

@section('title', 'Галерея — Крымский медосбор')

@section('content')
<section class="page-hero"><div class="container"><p class="eyebrow">{{ app()->getLocale() === 'ru' ? 'Из жизни пасеки' : 'From the apiary' }}</p><h1>{{ app()->getLocale() === 'ru' ? 'Там, где рождается вкус' : 'Where flavour begins' }}</h1><p>{{ app()->getLocale() === 'ru' ? 'Сезон за сезоном — цветы, ульи, руки и тёплый свет, из которых складывается каждая банка.' : 'Season after season — flowers, hives, hands and warm light behind every jar.' }}</p></div></section>
<section class="section-pad gallery-page-section"><div class="container"><div class="gallery-grid">@foreach($gallery as $index => $item)<figure class="gallery-item gallery-item-{{ ($index % 5) + 1 }}"><img src="{{ $item->image }}" alt="{{ $item->{'alt_'.app()->getLocale()} ?: $item->alt_ru }}"><figcaption>{{ $item->{'title_'.app()->getLocale()} ?: $item->title_ru }}</figcaption></figure>@endforeach</div></div></section>
@endsection
