<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'street',
        'exterior_number',
        'interior_number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country',
        'references',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Dirección formateada en una sola línea.
     */
    public function getFormattedAttribute(): string
    {
        $parts = array_filter([
            $this->street . ($this->exterior_number ? ' #' . $this->exterior_number : ''),
            $this->interior_number ? 'Int. ' . $this->interior_number : null,
            $this->neighborhood,
            $this->city,
            $this->state,
            'C.P. ' . $this->postal_code,
        ]);
        return implode(', ', $parts);
    }
}
