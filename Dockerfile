FROM php:8.3-fpm

# 1) Actualizar e instalar dependencias
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
 && docker-php-ext-install pdo_pgsql pgsql zip gd \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2) Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3) Directorio de trabajo
WORKDIR /var/www

# 4) Copiar todo el proyecto
COPY . .

# 5) Copiar config de nginx y supervisor
#   (asegúrate de que estos paths existen en tu repo)
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 6) Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 7) Permisos para storage y cache
RUN chmod -R 775 storage bootstrap/cache || true

# 8) Limpiar y cachear configuración y rutas (si falla, no rompe el build)
RUN php artisan config:clear || true \
 && php artisan config:cache || true \
 && php artisan route:clear || true \
 && php artisan route:cache || true

# 9) Exponer puerto 80 (nginx)
EXPOSE 80

# 10) Iniciar supervisor (que levanta nginx + php-fpm)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
