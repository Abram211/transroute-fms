FROM composer:2.8.6 AS vendor

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
COPY . ./
RUN composer install --no-interaction --prefer-dist --no-progress --optimize-autoloader --no-dev --no-scripts

FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libpq-dev \
        default-mysql-client \
        postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl gd bcmath intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html
COPY --from=vendor /var/www/html/vendor ./vendor

RUN php artisan package:discover --ansi \
    && chmod -R 775 storage bootstrap/cache

ENV PORT=8000

EXPOSE 8000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT}"]
