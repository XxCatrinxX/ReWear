<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'buyer_id',
        'address_id',
        'status',
        'subtotal',
        'shipping_cost',
        'total',
        'notes',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    public static array $statuses = [
        'pendiente'  => ['label' => 'Pendiente',  'color' => 'warning'],
        'pagado'     => ['label' => 'Pagado',      'color' => 'info'],
        'enviado'    => ['label' => 'Enviado',     'color' => 'primary'],
        'entregado'  => ['label' => 'Entregado',   'color' => 'success'],
        'cancelado'  => ['label' => 'Cancelado',   'color' => 'danger'],
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statuses[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::$statuses[$this->status]['color'] ?? 'secondary';
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format((float) $this->total, 2);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '$' . number_format((float) $this->subtotal, 2);
    }

    // ─── Relaciones ─────────────────────────────────────────────────────────────

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(OrderMessage::class)->orderBy('created_at', 'asc');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(OrderReport::class)->latest();
    }
}
