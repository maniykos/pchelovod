#!/bin/sh
set -eu

cd /var/www/html

mkdir -p bootstrap/cache storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data bootstrap/cache storage
chmod -R ug+rwX bootstrap/cache storage
# nginx runs as a separate user and must traverse to the public upload disk.
chmod 755 storage/app storage/app/public

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
if [ "${SEED_DEMO_DATA:-false}" = "true" ]; then
  php artisan db:seed --force
fi

exec "$@"
