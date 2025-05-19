# Stage 1 - Build
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl zip pdo pdo_pgsql pgsql

# Set working directory
WORKDIR /var/www

# Copy all files first
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions (optional for Laravel)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose port (for FPM)
EXPOSE 9000

CMD ["php-fpm"]
