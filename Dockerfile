FROM php:8.3-fpm-alpine

WORKDIR /var/www

# 1. Paquetes del sistema (PHP + Nginx + Supervisor + PostgreSQL + Node/Vite)
RUN apk add --no-cache \
    nginx supervisor \
    postgresql-client msmtp perl wget procps shadow libzip \
    libpng libjpeg-turbo libwebp freetype icu postgresql-dev \
    nodejs npm && \
    apk add --no-cache --virtual build-deps \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd pdo_pgsql pgsql intl bcmath opcache exif zip && \
    apk del build-deps && rm -rf /usr/src/php*

# 2. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copiar código del proyecto
COPY . /var/www

# 4. Nginx: usar tu config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# 5. Permisos para Laravel
RUN chown -R www-data:www-data /var/www

# 6. Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# 7. Compilar assets con Vite (modo producción)
RUN npm install && npm run build

# 8. Archivo .env de producción se gestionará por variables de entorno,
#    pero aseguramos la clave si viene por APP_KEY:
RUN php artisan config:clear

# 9. Supervisor: orquesta PHP-FPM + Nginx en el mismo contenedor
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
