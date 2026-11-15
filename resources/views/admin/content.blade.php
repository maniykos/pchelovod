@extends('admin.layout')

@section('title', 'Контент — Крымский медосбор')
@section('heading', 'Контент сайта')

@section('content')
<div class="admin-content-stack">
    <section id="contacts" class="admin-panel">
        <div class="admin-panel-heading"><div><p class="eyebrow">01 / КОНТАКТЫ</p><h2>Как с вами связаться</h2></div></div>
        <form class="admin-form compact" method="post" action="{{ route('admin.contacts.update') }}">
            @csrf @method('PUT')
            <div class="admin-form-grid">
                <label>Телефон<input name="phone" value="{{ $contacts->phone }}" required></label>
                <label>Telegram<input name="telegram" value="{{ $contacts->telegram }}" required></label>
                <label>MAX<input name="max_username" value="{{ $contacts->max_username }}" required></label>
                <label>Email<input name="email" value="{{ $contacts->email }}"></label>
                <label>Адрес RU<input name="address_ru" value="{{ $contacts->address_ru }}" required></label>
                <label>Адрес EN<input name="address_en" value="{{ $contacts->address_en }}" required></label>
            </div>
            <button class="button button-dark" type="submit">Сохранить контакты <span>↗</span></button>
        </form>
    </section>

    <section id="blog" class="admin-panel">
        <div class="admin-panel-heading"><div><p class="eyebrow">02 / БЛОГ</p><h2>Добавить статью</h2></div></div>
        <form class="admin-form compact" method="post" action="{{ route('admin.blog.store') }}">
            @csrf
            <div class="admin-form-grid">
                <label>Заголовок RU<input name="title_ru" required placeholder="Почему мёд кристаллизуется"></label>
                <label>Заголовок EN<input name="title_en" required placeholder="Why honey crystallises"></label>
                <label>Slug<input name="slug" required placeholder="why-honey-crystallises"></label>
                <label>Изображение URL<input name="image" required placeholder="https://images.unsplash.com/..."></label>
                <label>Кратко RU<textarea name="excerpt_ru" required rows="3"></textarea></label>
                <label>Кратко EN<textarea name="excerpt_en" required rows="3"></textarea></label>
                <label class="span-2">Текст RU<textarea name="body_ru" required rows="5"></textarea></label>
                <label class="span-2">Текст EN<textarea name="body_en" required rows="5"></textarea></label>
            </div>
            <input type="hidden" name="published_at" value="{{ now()->format('Y-m-d H:i:s') }}">
            <label class="checkbox-label"><input type="checkbox" name="is_published" value="1" checked> Опубликовать сразу</label>
            <button class="button button-dark" type="submit">Опубликовать статью <span>↗</span></button>
        </form>
        <div class="admin-list">
            @foreach($posts as $post)
                <details class="admin-edit-row">
                    <summary><span>{{ optional($post->published_at)->format('d.m.Y') }}</span><strong>{{ $post->title_ru }}</strong><b>Редактировать</b></summary>
                    <form class="admin-form compact" method="post" action="{{ route('admin.blog.update', $post) }}">
                        @csrf @method('PUT')
                        <div class="admin-form-grid">
                            <label>Заголовок RU<input name="title_ru" value="{{ $post->title_ru }}" required></label>
                            <label>Заголовок EN<input name="title_en" value="{{ $post->title_en }}" required></label>
                            <label>Slug<input name="slug" value="{{ $post->slug }}" required></label>
                            <label>Изображение URL<input name="image" value="{{ $post->image }}" required></label>
                            <label>Кратко RU<textarea name="excerpt_ru" required rows="3">{{ $post->excerpt_ru }}</textarea></label>
                            <label>Кратко EN<textarea name="excerpt_en" required rows="3">{{ $post->excerpt_en }}</textarea></label>
                            <label class="span-2">Текст RU<textarea name="body_ru" required rows="5">{{ $post->body_ru }}</textarea></label>
                            <label class="span-2">Текст EN<textarea name="body_en" required rows="5">{{ $post->body_en }}</textarea></label>
                        </div>
                        <input type="hidden" name="published_at" value="{{ optional($post->published_at)->format('Y-m-d H:i:s') }}">
                        <label class="checkbox-label"><input type="checkbox" name="is_published" value="1" @checked($post->is_published)> Опубликована</label>
                        <button class="button button-dark" type="submit">Сохранить статью <span>↗</span></button>
                    </form>
                    <form method="post" action="{{ route('admin.blog.destroy', $post) }}" class="admin-delete-form">@csrf @method('DELETE')<button class="icon-button" type="submit" aria-label="Удалить статью">×</button></form>
                </details>
            @endforeach
        </div>
    </section>

    <section id="certificates" class="admin-panel">
        <div class="admin-panel-heading"><div><p class="eyebrow">03 / ДОКУМЕНТЫ</p><h2>Сертификаты</h2></div></div>
        <form class="admin-form compact" method="post" action="{{ route('admin.certificates.store') }}">
            @csrf
            <div class="admin-form-grid">
                <label>Название RU<input name="title_ru" required></label>
                <label>Название EN<input name="title_en" required></label>
                <label>Организация<input name="issuer" required></label>
                <label>Год<input type="number" name="year" required value="{{ date('Y') }}"></label>
                <label class="span-2">Изображение URL<input type="url" name="image" required></label>
                <label>Описание RU<textarea name="description_ru" rows="3"></textarea></label>
                <label>Описание EN<textarea name="description_en" rows="3"></textarea></label>
            </div>
            <button class="button button-dark" type="submit">Добавить сертификат <span>↗</span></button>
        </form>
        <div class="admin-list">
            @foreach($certificates as $certificate)
                <details class="admin-edit-row">
                    <summary><span>{{ $certificate->year }}</span><strong>{{ $certificate->title_ru }}</strong><b>Редактировать</b></summary>
                    <form class="admin-form compact" method="post" action="{{ route('admin.certificates.update', $certificate) }}">
                        @csrf @method('PUT')
                        <div class="admin-form-grid">
                            <label>Название RU<input name="title_ru" value="{{ $certificate->title_ru }}" required></label>
                            <label>Название EN<input name="title_en" value="{{ $certificate->title_en }}" required></label>
                            <label>Организация<input name="issuer" value="{{ $certificate->issuer }}" required></label>
                            <label>Год<input type="number" name="year" value="{{ $certificate->year }}" required></label>
                            <label class="span-2">Изображение URL<input type="url" name="image" value="{{ $certificate->image }}" required></label>
                            <label>Описание RU<textarea name="description_ru" rows="3">{{ $certificate->description_ru }}</textarea></label>
                            <label>Описание EN<textarea name="description_en" rows="3">{{ $certificate->description_en }}</textarea></label>
                        </div>
                        <button class="button button-dark" type="submit">Сохранить сертификат <span>↗</span></button>
                    </form>
                    <form method="post" action="{{ route('admin.certificates.destroy', $certificate) }}" class="admin-delete-form">@csrf @method('DELETE')<button class="icon-button" type="submit" aria-label="Удалить сертификат">×</button></form>
                </details>
            @endforeach
        </div>
    </section>

    <section id="gallery" class="admin-panel">
        <div class="admin-panel-heading"><div><p class="eyebrow">04 / ГАЛЕРЕЯ</p><h2>Добавить кадр</h2></div></div>
        <form class="admin-form compact" method="post" action="{{ route('admin.gallery.store') }}">
            @csrf
            <div class="admin-form-grid">
                <label>Название RU<input name="title_ru" required></label>
                <label>Название EN<input name="title_en" required></label>
                <label class="span-2">Изображение URL<input type="url" name="image" required></label>
                <label>Alt RU<input name="alt_ru"></label>
                <label>Alt EN<input name="alt_en"></label>
                <label>Порядок<input type="number" name="sort_order" value="0"></label>
            </div>
            <button class="button button-dark" type="submit">Добавить фото <span>↗</span></button>
        </form>
        <div class="admin-list">
            @foreach($gallery as $item)
                <details class="admin-edit-row">
                    <summary><span><img src="{{ $item->image }}" alt=""></span><strong>{{ $item->title_ru }}</strong><b>Редактировать</b></summary>
                    <form class="admin-form compact" method="post" action="{{ route('admin.gallery.update', $item) }}">
                        @csrf @method('PUT')
                        <div class="admin-form-grid">
                            <label>Название RU<input name="title_ru" value="{{ $item->title_ru }}" required></label>
                            <label>Название EN<input name="title_en" value="{{ $item->title_en }}" required></label>
                            <label class="span-2">Изображение URL<input type="url" name="image" value="{{ $item->image }}" required></label>
                            <label>Alt RU<input name="alt_ru" value="{{ $item->alt_ru }}"></label>
                            <label>Alt EN<input name="alt_en" value="{{ $item->alt_en }}"></label>
                            <label>Порядок<input type="number" name="sort_order" value="{{ $item->sort_order }}"></label>
                        </div>
                        <label class="checkbox-label"><input type="checkbox" name="is_published" value="1" @checked($item->is_published)> Показывать на сайте</label>
                        <button class="button button-dark" type="submit">Сохранить фото <span>↗</span></button>
                    </form>
                    <form method="post" action="{{ route('admin.gallery.destroy', $item) }}" class="admin-delete-form">@csrf @method('DELETE')<button class="icon-button" type="submit" aria-label="Удалить фото">×</button></form>
                </details>
            @endforeach
        </div>
    </section>
</div>
@endsection
