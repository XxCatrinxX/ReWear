#!/bin/bash
set -e

# Reemplazar la variable PORT en el archivo principal de Nginx
envsubst '$PORT' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Asegurar permisos de escritura para storage y cache
mkdir -p /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Crear archivo SQLite de respaldo si se usa SQLite
if [ "${DB_CONNECTION}" = "sqlite" ] || [ -z "${DB_CONNECTION}" ]; then
    touch /var/www/html/database/database.sqlite
    chmod 777 /var/www/html/database/database.sqlite
fi

# Auto-generar APP_KEY si no está configurada en las variables de entorno
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY no detectada. Generando una nueva clave para la aplicación..."
    php artisan key:generate --force
fi

# Crear enlace simbólico de almacenamiento si no existe
php artisan storage:link || true

# Limpiar cachés de archivo (config, views) antes de ejecutar migraciones
php artisan config:clear
php artisan view:clear

# Ejecutar migraciones de base de datos y sembrado inicial
echo "Ejecutando migraciones y sembrado de categorías..."
php artisan migrate --force || echo "Advertencia: La migración falló pero la aplicación continuará."
php artisan db:seed --class=CategorySeeder --force || true

# Limpiar cache de base de datos DESPUÉS de que las tablas existan
php artisan cache:clear || true

# Limpiar y optimizar cachés en producción
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "ReWear iniciado correctamente para Railway."

# Iniciar PHP-FPM en segundo plano y Nginx en primer plano
php-fpm -D
sleep 1
exec nginx -g 'daemon off;'

