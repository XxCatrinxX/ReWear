<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Resuelve y formatea cualquier URL de imagen de manera universal.
     * Compatible con PC, PWA, dispositivos móviles en red local (IPs) y dominios de producción.
     *
     * @param string|null $path Ruta de la imagen guardada en BD o URL externa
     * @param string $fallback URL de imagen por defecto si la ruta está vacía
     * @return string URL accesible universalmente
     */
    public static function url(?string $path, string $fallback = ''): string
    {
        if (empty($path)) {
            return $fallback;
        }

        // 1. Si ya es una URL externa (http:// o https://)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // 2. Normalizar la ruta interna eliminando prefijos accidentales
        $cleanPath = ltrim($path, '/');
        if (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        // 3. Generar la URL basada en el Host de la petición actual (evita forzar localhost en celulares de la red)
        if (app()->bound('request') && request()->httpHost()) {
            $baseUrl = request()->getBaseUrl(); // ej. "/ReWear/public" o ""
            return request()->schemeAndHttpHost() . $baseUrl . '/storage/' . $cleanPath;
        }

        return asset('storage/' . $cleanPath);
    }
}
