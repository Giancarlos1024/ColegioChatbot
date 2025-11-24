FROM php:8.3-fpm

# 1) Paquetes de sistema
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
 && docker-php-ext-install pdo_pgsql zip gd \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2) Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3) Código Laravel
WORKDIR /var/www
COPY . .

# 4) Nginx config  👈 AQUÍ EL CAMBIO IMPORTANTE
# Borramos el sitio por defecto y usamos el nuestro
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default || true

# Copiamos tu configuración como sitio principal
COPY docker/nginx/default.conf /etc/nginx/sites-available/laravel.conf
RUN ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/laravel.conf

# 5) Supervisord config
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 6) Dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# 7) Permisos
RUN chmod -R 775 storage bootstrap/cache || true

# 8) Cache de config y rutas (con || true por si falla en build)
RUN php artisan config:clear || true \
 && php artisan config:cache || true \
 && php artisan route:clear || true \
 && php artisan route:cache || true

EXPOSE 80

# 9) Arrancar supervisord (nginx + php-fpm)
CMD ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]
