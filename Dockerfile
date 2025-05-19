# Use PHP image with Composer and required extensions
FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev unzip git curl zip \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring exif pcntl

# Install Composer globally
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy everything
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port Render expects
EXPOSE 10000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
