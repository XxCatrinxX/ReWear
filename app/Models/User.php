<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'ine_photo',
        'bio',
        'is_admin',
        'is_seller',
        'status',
        'pending_balance',
        'available_balance',
        'clabe',
        'bank_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'is_seller'         => 'boolean',
            'status'            => 'boolean',
            'pending_balance'   => 'decimal:2',
            'available_balance' => 'decimal:2',
        ];
    }

    // ─── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Determina si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Determina si el usuario es vendedor.
     */
    public function isSeller(): bool
    {
        return $this->is_seller === true;
    }

    /**
     * Convierte al usuario en vendedor.
     */
    public function becomeSeller(): void
    {
        $this->update(['is_seller' => true]);
    }

    /**
     * Nombre completo desde el perfil o name por defecto.
     */
    public function getFullNameAttribute(): string
    {
        if ($this->profile && ($this->profile->first_name || $this->profile->last_name)) {
            return trim("{$this->profile->first_name} {$this->profile->last_name}");
        }
        return $this->name;
    }

    /**
     * URL del avatar o placeholder.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff&size=128';
    }

    // ─── Relaciones ─────────────────────────────────────────────────────────────

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Ventas realizadas como vendedor (ítems donde este user es seller).
     */
    public function salesItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }
}
