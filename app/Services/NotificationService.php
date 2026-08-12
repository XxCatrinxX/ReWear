<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Envía una notificación a un usuario.
     */
    public static function send(int $userId, string $title, string $message, ?string $link = null, string $type = 'info'): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'link'    => $link,
            'type'    => $type,
        ]);
    }
}
