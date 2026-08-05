<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Sube las imágenes de un producto y crea los registros en la BD.
     */
    public function uploadImages(Product $product, array $images): void
    {
        $sortOrder = $product->images()->max('sort_order') ?? 0;

        foreach ($images as $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $path = $image->store("products/{$product->id}", 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'sort_order' => ++$sortOrder,
            ]);
        }
    }

    /**
     * Establece la imagen de portada del producto.
     * Si no se especifica, usa la primera imagen.
     */
    public function setCoverImage(Product $product): void
    {
        if (!$product->cover_image) {
            $first = $product->images()->orderBy('sort_order')->first();
            if ($first) {
                $product->update(['cover_image' => $first->image_path]);
            }
        }
    }

    /**
     * Elimina imágenes específicas de un producto.
     */
    public function deleteImages(Product $product, array $imageIds): void
    {
        $images = ProductImage::where('product_id', $product->id)
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Actualizar cover si se eliminó
        if ($product->cover_image && !$product->images()->where('image_path', $product->cover_image)->exists()) {
            $first = $product->images()->orderBy('sort_order')->first();
            $product->update(['cover_image' => $first?->image_path]);
        }
    }

    /**
     * Elimina todas las imágenes del producto.
     */
    public function deleteAllImages(Product $product): void
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $product->images()->delete();
    }

    /**
     * Sube el avatar de un usuario.
     */
    public function uploadAvatar(UploadedFile $file, int $userId): string
    {
        $path = $file->store("avatars/{$userId}", 'public');
        return $path;
    }
}
