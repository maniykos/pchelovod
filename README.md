# Honey Atelier

Русскоязычный и англоязычный сайт пасеки на Laravel 12, MongoDB и Vue 3.

## Что уже есть

- Home в стиле фермерского бренда с hero-блоком, коллекцией товаров, галереей, преимуществами и блогом.
- Отдельные страницы `/products`, `/blog`, `/gallery`, `/certificates` и `/contacts`; на Home остаются hero, преимущества и три последние статьи.
- Каталог товаров без корзины: посетитель выбирает товар и оставляет заявку.
- Блог, сертификаты и контакты.
- Админка `/admin` для товаров, статей, сертификатов, галереи и контактных данных.
- Изображения в админке загружаются файлами и сохраняются в публичное Laravel-хранилище; валюта каталога — российский рубль (`₽`).
- Тестовые товары, две статьи, сертификаты и фотографии в `database/seeders/DatabaseSeeder.php`.
- Переключение русского и английского языка через `/locale/ru` и `/locale/en`.

## Запуск через Docker Compose

```bash
cp .env.example .env
docker compose up -d --build
```

Если контейнер `app` уже был создан старой конфигурацией, пересоздайте volumes один раз:

```bash
docker compose down -v
docker compose up -d --build
```

После запуска:

- сайт: `http://127.0.0.1:8000`
- Vite: `http://127.0.0.1:5173`
- MongoDB: `mongodb://127.0.0.1:27017/honey_atelier`

Тестовые данные загружаются автоматически контейнером Laravel через `DatabaseSeeder`.

Проверка Laravel-контейнера:

```bash
docker compose ps -a
docker compose logs -f app
```

После изменений в `docker/php/Dockerfile` или `docker/php/entrypoint.sh` пересоберите только приложение:

```bash
docker compose build --no-cache app
docker compose up -d --force-recreate app
docker compose ps -a
```

Остановка:

```bash
docker compose down
```

Удаление тестовой базы и volumes:

```bash
docker compose down -v
```

MongoDB подключается внутри Compose через `mongodb://mongo:27017`.

Если Docker пока недоступен, после установки зависимостей запускается обычный Laravel front controller. Пока `vendor/` отсутствует, `public/index.php` автоматически показывает автономный preview-макет, чтобы дизайн и админку можно было открыть командой:

```bash
php -S 127.0.0.1:8000 -t public
```

После запуска откройте `http://127.0.0.1:8000/`, а admin preview — `http://127.0.0.1:8000/?view=admin`.
