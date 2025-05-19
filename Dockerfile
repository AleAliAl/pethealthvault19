FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl zip pdo pdo_mysql pdo_pgsql pgsql


# Copy composer and install dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy the rest of your app
COPY . .

# Build your frontend (if you have node stuff)
RUN npm install && npm run build

CMD ["php-fpm"]
