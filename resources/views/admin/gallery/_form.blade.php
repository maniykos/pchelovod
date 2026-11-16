@csrf
@if($errors->any())
    <div class="flash-error" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<div class="admin-form-grid">
    <label>Название RU<input name="title_ru" value="{{ old('title_ru', $galleryItem->title_ru ?? '') }}" required></label>
    <label>Название EN<input name="title_en" value="{{ old('title_en', $galleryItem->title_en ?? '') }}" required></label>
    <label class="span-2">Фото или видео
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm" {{ empty($galleryItem->image) ? 'required' : '' }}>
        <small>JPG, PNG, WebP, GIF, MP4 или WebM — до 100 МБ. При редактировании можно оставить текущий файл.</small>
    </label>
    <label>Описание RU<input name="alt_ru" value="{{ old('alt_ru', $galleryItem->alt_ru ?? '') }}"></label>
    <label>Описание EN<input name="alt_en" value="{{ old('alt_en', $galleryItem->alt_en ?? '') }}"></label>
    <label>Порядок<input type="number" name="sort_order" value="{{ old('sort_order', $galleryItem->sort_order ?? 0) }}"></label>
</div>
<input type="hidden" name="is_published" value="0">
<label class="checkbox-label"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $galleryItem->is_published ?? true))> Показывать на сайте</label>
<button class="button button-dark" type="submit">{{ $submitLabel }} <span>↗</span></button>
