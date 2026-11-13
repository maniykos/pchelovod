<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Honey Atelier — мёд с собственной пасеки, собранный в чистых цветущих долинах.">
    <title>@yield('title', 'Honey Atelier — натуральный мёд')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <header class="site-header">
            <div class="container nav-wrap">
                <a class="brand" href="{{ route('home') }}" aria-label="Honey Atelier">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 48 48" role="img"><path d="M24 3 43 14v20L24 45 5 34V14L24 3Z"/><path d="m13 17 11 6 11-6M13 31l11-6 11 6M24 23v22"/></svg>
                    </span>
                    <span class="brand-copy"><strong>HONEY</strong><em>ATELIER</em></span>
                </a>
                <button class="menu-toggle" type="button" aria-label="Открыть меню" data-menu-toggle><span></span><span></span></button>
                <nav class="main-nav" data-menu>
                    <a href="{{ route('home') }}">{{ app()->getLocale() === 'ru' ? 'Главная' : 'Home' }}</a>
                    <a href="{{ route('products.index') }}">{{ app()->getLocale() === 'ru' ? 'Товары' : 'Shop' }}</a>
                    <a href="{{ route('blog.index') }}">{{ app()->getLocale() === 'ru' ? 'Блог' : 'Journal' }}</a>
                    <a href="{{ route('gallery.index') }}">{{ app()->getLocale() === 'ru' ? 'Галерея' : 'Gallery' }}</a>
                    <a href="{{ route('certificates.index') }}">{{ app()->getLocale() === 'ru' ? 'Сертификаты' : 'Certificates' }}</a>
                    <a href="{{ route('contacts.index') }}">{{ app()->getLocale() === 'ru' ? 'Контакты' : 'Contacts' }}</a>
                </nav>
                <div class="nav-actions">
                    <div class="lang-switcher">
                        <a class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}" href="{{ route('locale', 'ru') }}">RU</a>
                        <span>/</span>
                        <a class="{{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('locale', 'en') }}">EN</a>
                    </div>
                    <a class="circle-link" href="{{ route('contacts.index') }}" aria-label="{{ app()->getLocale() === 'ru' ? 'Заказать' : 'Order' }}"><span>↗</span></a>
                </div>
            </div>
        </header>

        <main>@yield('content')</main>

        <footer class="site-footer">
            <div class="container footer-grid">
                <div>
                    <a class="brand brand-footer" href="{{ route('home') }}"><span class="brand-mark"><svg viewBox="0 0 48 48"><path d="M24 3 43 14v20L24 45 5 34V14L24 3Z"/><path d="m13 17 11 6 11-6M13 31l11-6 11 6M24 23v22"/></svg></span><span class="brand-copy"><strong>HONEY</strong><em>ATELIER</em></span></a>
                    <p>{{ app()->getLocale() === 'ru' ? 'Мёд, который начинается с заботы о пчёлах и заканчивается вашим любимым ритуалом.' : 'Honey that starts with care for bees and ends as your favourite ritual.' }}</p>
                </div>
                <div><p class="footer-label">{{ app()->getLocale() === 'ru' ? 'Навигация' : 'Explore' }}</p><a href="{{ route('products.index') }}">{{ app()->getLocale() === 'ru' ? 'Товары' : 'Shop' }}</a><a href="{{ route('blog.index') }}">{{ app()->getLocale() === 'ru' ? 'Блог' : 'Journal' }}</a><a href="{{ route('gallery.index') }}">{{ app()->getLocale() === 'ru' ? 'Галерея' : 'Gallery' }}</a><a href="{{ route('certificates.index') }}">{{ app()->getLocale() === 'ru' ? 'Сертификаты' : 'Certificates' }}</a></div>
                <div><p class="footer-label">{{ app()->getLocale() === 'ru' ? 'Связаться' : 'Contact' }}</p><a href="tel:{{ $contacts->phone ?? '+37400000000' }}">{{ $contacts->phone ?? '+374 00 000 000' }}</a><a href="https://t.me/{{ $contacts->telegram ?? 'honey_atelier' }}" target="_blank">Telegram</a><a href="https://max.ru/{{ $contacts->max_username ?? 'honey_atelier' }}" target="_blank">MAX</a></div>
                <div class="footer-note"><span>© {{ date('Y') }} Honey Atelier</span><span>{{ app()->getLocale() === 'ru' ? 'Сделано с уважением к природе' : 'Made with respect for nature' }}</span></div>
            </div>
        </footer>
    </div>
</body>
</html>
