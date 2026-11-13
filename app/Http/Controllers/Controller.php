<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function locale(): string
    {
        return app()->getLocale() === 'en' ? 'en' : 'ru';
    }

    protected function localized(object|array $item, string $field, ?string $locale = null): string
    {
        $locale ??= $this->locale();
        $key = $field.'_'.$locale;
        $fallback = $field.'_'.($locale === 'ru' ? 'en' : 'ru');
        $get = static fn (string $name) => is_array($item) ? ($item[$name] ?? null) : ($item->{$name} ?? null);

        return (string) ($get($key) ?: $get($fallback) ?: '');
    }
}
