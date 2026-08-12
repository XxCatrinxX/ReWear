<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'link',
        'type',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public static array $typeIcons = [
        'sale'     => ['icon' => 'bx-dollar-circle', 'color' => 'bg-emerald-100 text-[#2E7D32]'],
        'question' => ['icon' => 'bx-help-circle',   'color' => 'bg-amber-100 text-amber-700'],
        'answer'   => ['icon' => 'bx-comment-detail', 'color' => 'bg-blue-100 text-blue-700'],
        'shipment' => ['icon' => 'bx-package',        'color' => 'bg-purple-100 text-purple-700'],
        'info'     => ['icon' => 'bx-bell',           'color' => 'bg-gray-100 text-gray-700'],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): void
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }
}
