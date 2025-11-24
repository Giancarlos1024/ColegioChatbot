FROM php:8.3-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
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

# Configuración de nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Config supervisord
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copiar aplicación
WORKDIR /var/www
COPY . .

# Instalar Laravel deps
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chmod -R 775 storage bootstrap/cache || true

# Optimizar cache
RUN php artisan config:clear || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true

# Render necesita EXPOSE
EXPOSE 80

# Comando de inicio
CMD ["/usr/bin/supervisord"]
