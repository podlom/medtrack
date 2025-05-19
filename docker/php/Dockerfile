FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libpq-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
