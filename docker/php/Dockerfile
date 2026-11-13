FROM php:8.3-fpm-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libicu-dev libonig-dev libssl-dev pkg-config \
    && docker-php-ext-install bcmath intl mbstring opcache zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && rm -rf /var/lib/apt/lists/* /tmp/pear

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./
RUN composer install --no-interaction --prefer-dist --no-dev --no-scripts \
    && composer dump-autoload --optimize --no-interaction --no-scripts \
    && cp -a vendor /opt/vendor

COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-honey-atelier.ini
COPY docker/php/entrypoint.sh /usr/local/bin/honey-entrypoint
RUN chmod +x /usr/local/bin/honey-entrypoint

ENTRYPOINT ["honey-entrypoint"]
