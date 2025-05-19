# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql pgsql zip mbstring exif pcntl bcmath xml

# Install Composer globally
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application files
COPY . .

# Install PHP dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build

# Generate Laravel config cache and optimize
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Set proper permissions for storage and bootstrap cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 8000 for the Laravel app
EXPOSE 8000

# Run Laravel development server (you can use a production server like php-fpm+nginx if you want)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
