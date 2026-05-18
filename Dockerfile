FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx nodejs npm git curl zip unzip \
    libpng-dev libxml2-dev oniguruma-dev supervisor

RUN docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

ENTRYPOINT []
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]