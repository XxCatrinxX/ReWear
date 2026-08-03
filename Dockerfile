# Stage 1: Build Frontend Assets with Node.js
FROM node:20-alpine as frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Install Composer Dependencies
FROM composer:2 as vendor
WORKDIR /app
COPY composer*.json ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Stage 3: Production Runtime (PHP 8.3 FPM + Nginx)
FROM php:8.3-fpm-alpine

# Instalar dependencias del sistema y extensiones de PHP necesarias para Laravel
RUN apk add --no-cache \
    nginx \
    gettext \
    bash \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip bcmath intl opcache

WORKDIR /var/www/html

# Copiar aplicación desde vendor y frontend
COPY --chown=www-data:www-data . /var/www/html
COPY --from=vendor --chown=www-data:www-data /app/vendor /var/www/html/vendor
COPY --from=frontend --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Configurar permisos para storage y bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar configuración de Nginx y entrypoint
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf.template
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Puerto asignado dinámicamente por Railway
ENV PORT=80
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
