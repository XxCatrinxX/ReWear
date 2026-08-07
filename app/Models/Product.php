<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'brand',
        'size',
        'color',
        'condition',
        'price',
        'stock',
        'is_sold',
        'is_featured',
        'is_active',
        'cover_image',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_sold'     => 'boolean',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    // ─── Condiciones legibles ────────────────────────────────────────────────────

    public static array $conditions = [
        'nuevo'       => 'Nuevo con etiqueta',
        'como_nuevo'  => 'Como nuevo',
        'bueno'       => 'Buen estado',
        'aceptable'   => 'Aceptable',
    ];

    public static array $sizes = [
        'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL',
        '32', '34', '36', '38', '40', '42', '44',
        'Talla única',
    ];

    // ─── Auto-slug ───────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $base = Str::slug($product->title);
                $slug = $base;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$count}";
                    $count++;
                }
                $product->slug = $slug;
            }
        });
    }

    // ----------------------------------
    public static array $colors = [
        'Negro'      => '#000000',
        'Blanco'     => '#FFFFFF',
        'Gris'       => '#9CA3AF',
        'Azul'       => '#1D4ED8',
        'Rojo'       => '#DC2626',
        'Verde'      => '#15803D',
        'Amarillo'   => '#FACC15',
        'Rosa'       => '#F472B6',
        'Morado'     => '#7E22CE',
        'Beige'      => '#E5D3B3',
        'Café'       => '#78350F',
        'Multicolor' => 'linear-gradient(45deg, #f06, #3f51b5)',
    ];

    // ─── Accessors ───────────────────────────────────────────────────────────────

    public function getConditionLabelAttribute(): string
    {
        return self::$conditions[$this->condition] ?? $this->condition;
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        if ($this->images->isNotEmpty()) {
            return asset('storage/' . $this->images->first()->image_path);
        }
        
        $placeholders = [
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1496747611176-843222e1e57c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1509631179647-0177331693ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1479064555552-3ef4979f8908?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
        ];
        return $placeholders[$this->id % count($placeholders)];
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_sold', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByCategory($query, int|string $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceBetween($query, ?float $min = null, ?float $max = null)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    // ─── Relaciones ─────────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ProductQuestion::class)->latest();
    }
}
