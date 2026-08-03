#!/bin/bash
set -e

# Reemplazar la variable PORT en el archivo de Nginx
envsubst '$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Crear enlace simbólico de almacenamiento si no existe
php artisan storage:link || true

# Ejecutar migraciones automáticas en producción
echo "Ejecutando migraciones de base de datos..."
php artisan migrate --force

# Limpiar y optimizar cachés en producción
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "ReWear iniciado correctamente para Railway."

# Iniciar PHP-FPM en segundo plano y Nginx en primer plano
php-fpm -D
exec nginx -g 'daemon off;'
