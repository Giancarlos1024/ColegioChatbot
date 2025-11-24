FROM php:8.3-fpm

# actualizar e instalar dependencias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql zip gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# permisos para storage y cache
RUN chmod -R 775 storage bootstrap/cache

# generar cache
RUN php artisan config:cache
RUN php artisan route:cache

CMD ["php-fpm"]
