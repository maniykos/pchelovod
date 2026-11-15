@extends('admin.layout')
@section('title', 'Товары — Крымский медосбор')
@section('heading', 'Товары')
@section('content')
<div class="admin-page-toolbar"><div><p>Каталог без корзины: посетитель оставляет заявку на выбранный товар.</p></div><a class="button button-dark" href="{{ route('admin.products.create') }}">+ Добавить товар</a></div>
<div class="admin-table"><div class="admin-table-head"><span>Товар</span><span>Цена</span><span>Статус</span><span>Действия</span></div>@forelse($products as $product)<div class="admin-table-row"><div class="admin-product-cell"><img src="{{ $product->image }}" alt=""><div><strong>{{ $product->title_ru }}</strong><small>{{ $product->unit }}</small></div></div><strong>{{ number_format($product->price, 0, ',', ' ') }} ₽</strong><span class="status-pill {{ $product->is_published ? 'status-live' : 'status-draft' }}">{{ $product->is_published ? 'Опубликован' : 'Черновик' }}</span><div class="admin-row-actions"><a class="text-link" href="{{ route('admin.products.edit', $product) }}">Изменить</a><form method="post" action="{{ route('admin.products.destroy', $product) }}">@csrf @method('DELETE')<button class="icon-button" type="submit" aria-label="Удалить">×</button></form></div></div>@empty<div class="admin-empty">Товаров пока нет.</div>@endforelse</div>
@endsection
