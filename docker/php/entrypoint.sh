#!/bin/sh
set -eu

cd /var/www/html

mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data bootstrap/cache storage
chmod -R ug+rwX bootstrap/cache storage

if [ ! -f vendor/autoload.php ]; then
  if [ -f /opt/vendor/autoload.php ]; then
    mkdir -p vendor
    cp -a /opt/vendor/. vendor/
  else
    composer install --no-interaction --prefer-dist --no-dev --no-scripts
  fi
fi

composer dump-autoload --optimize --no-interaction

if [ -z "${APP_KEY:-}" ]; then
  php artisan key:generate --force
fi
php artisan storage:link || true
php artisan db:seed --force

exec "$@"
