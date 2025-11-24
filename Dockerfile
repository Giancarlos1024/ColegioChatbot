# ------------------------------------------------------
# 1) Stage de Node para compilar Vite
# ------------------------------------------------------
FROM node:20-alpine AS node-build

WORKDIR /app

# Instalamos dependencias de frontend
COPY package*.json ./
RUN npm install

# Copiamos el código completo
COPY . ./

# Compilamos el frontend (Vite)
RUN npm run build



# ------------------------------------------------------
# 2) Stage de PHP + Nginx + Laravel
# ------------------------------------------------------
FROM php:8.3-fpm

# Paquetes del sistema necesarios
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
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*


# Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# ------------------------------------------------------
# Copiamos la app Laravel
# ------------------------------------------------------
WORKDIR /var/www
COPY . .

# Copiamos el build de Vite generado en el stage Node
COPY --from=node-build /app/public/build ./public/build


# ------------------------------------------------------
# Configuración de Nginx
# ------------------------------------------------------
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default || true
COPY docker/nginx/default.conf /etc/nginx/sites-available/laravel.conf
RUN ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/laravel.conf


# ------------------------------------------------------
# Configuración de Supervisor
# ------------------------------------------------------
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf


# ------------------------------------------------------
# Instala dependencias de Laravel
# ------------------------------------------------------
RUN composer install --no-dev --optimize-autoloader


# ------------------------------------------------------
# Permisos y cache
# ------------------------------------------------------
RUN chmod -R 775 storage bootstrap/cache || true

RUN php artisan config:clear || true \
 && php artisan config:cache || true \
 && php artisan route:clear || true \
 && php artisan route:cache || true


# Exponemos el puerto
EXPOSE 80

# Supervisord ejecuta PHP-FPM + Nginx
CMD ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]
