# ------------------------------------------------------
# 1) Stage de Node para compilar Vite
# ------------------------------------------------------
FROM node:18-alpine AS node-build

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . ./
RUN npm run build   # <-- COMPILA VITE A /public/build


# ------------------------------------------------------
# 2) Stage de PHP + Nginx + Laravel
# ------------------------------------------------------
FROM php:8.3-fpm

# Paquetes del sistema
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

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Código Laravel
WORKDIR /var/www
COPY . .

# 📌  COPIAR EL BUILD DEL FRONTEND
COPY --from=node-build /app/public/build ./public/build

# Configuración Nginx
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default || true
COPY docker/nginx/default.conf /etc/nginx/sites-available/laravel.conf
RUN ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/laravel.conf

# Supervisord
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chmod -R 775 storage bootstrap/cache || true

# Cache de config y rutas
RUN php artisan config:clear || true \
 && php artisan config:cache || true \
 && php artisan route:clear || true \
 && php artisan route:cache || true

EXPOSE 80

CMD ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]
