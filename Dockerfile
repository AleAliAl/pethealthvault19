# Stage 1: Build PHP dependencies using Composer
FROM composer:2.7 as composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2: Laravel + PHP
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

WORKDIR /var/www

COPY . .

# Copy built vendor directory from composer stage
COPY --from=composer /app/vendor ./vendor

RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
