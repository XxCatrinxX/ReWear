<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'carrier',
        'tracking_number',
        'status',
        'estimated_delivery',
        'shipped_at',
        'delivered_at',
        'tracking_history',
    ];

    protected $casts = [
        'tracking_history' => 'array',
        'shipped_at'       => 'datetime',
        'delivered_at'     => 'datetime',
    ];

    public static array $statuses = [
        'preparando'    => 'Preparando envío',
        'recolectado'   => 'Paquete recolectado',
        'en_transito'   => 'En tránsito',
        'en_sucursal'   => 'En sucursal',
        'entregado'     => 'Entregado',
        'fallido'       => 'Intento de entrega fallido',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
