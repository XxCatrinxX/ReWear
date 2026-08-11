<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReport extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'type',
        'reason',
        'description',
        'status',
        'admin_notes',
    ];

    public static array $statuses = [
        'pendiente'   => ['label' => 'Pendiente',   'bg' => 'bg-yellow-100 text-yellow-800'],
        'en_revision' => ['label' => 'En Revisión', 'bg' => 'bg-blue-100 text-blue-800'],
        'resuelto'    => ['label' => 'Resuelto',    'bg' => 'bg-green-100 text-green-800'],
        'desestimado' => ['label' => 'Desestimado', 'bg' => 'bg-gray-100 text-gray-800'],
    ];

    public static array $types = [
        'envio'    => 'Problema con el envío / Paquetería',
        'producto' => 'Problema con la prenda / Defectuoso',
        'otro'     => 'Otro inconveniente',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
