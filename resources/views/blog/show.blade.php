@extends('layouts.app')
@section('title', ($post->title_ru ?? 'Статья').' — Honey Atelier')
@section('content')<article class="article-page"><div class="container article-wrap"><p class="eyebrow">{{ optional($post->published_at)->format('d.m.Y') }} · {{ app()->getLocale() === 'ru' ? 'Блог' : 'Journal' }}</p><h1>{{ $post->{'title_'.app()->getLocale()} ?: $post->title_ru }}</h1><div class="article-cover" style="--article-image:url('{{ $post->image }}')"></div><div class="article-body">{!! $post->{'body_'.app()->getLocale()} ?: $post->body_ru !!}</div></div></article>@endsection
