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

# Crear archivo SQLite de respaldo solo si explícitamente se usa SQLite y no hay MySQL de Railway
if [ "${DB_CONNECTION}" = "sqlite" ] && [ -z "${MYSQLHOST}" ] && [ -z "${MYSQL_URL}" ]; then
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

# Limpiar cachés antes de ejecutar migraciones (importante para detectar cambios de env)
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Ejecutar migraciones de base de datos
echo "Ejecutando migraciones de base de datos..."
php artisan migrate --force || echo "Advertencia: La migración falló pero la aplicación continuará."

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

