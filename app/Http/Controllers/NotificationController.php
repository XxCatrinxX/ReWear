<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Muestra el panel/vista de notificaciones del usuario.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marca una notificación como leída y redirige a su enlace.
     */
    public function read(Request $request, Notification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            abort(403);
        }

        $notification->markAsRead();

        if ($notification->link) {
            return redirect($notification->link);
        }

        return back();
    }

    /**
     * Marca todas las notificaciones como leídas.
     */
    public function readAll(Request $request)
    {
        $request->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        return back()->with('success', 'Todas las notificaciones se han marcado como leídas.');
    }

    /**
     * Retorna las notificaciones no leídas en JSON para el Service Worker de segundo plano.
     */
    public function unreadJson(Request $request)
    {
        if (!$request->user()) {
            return response()->json([]);
        }

        $unread = $request->user()->notifications()
            ->whereNull('read_at')
            ->latest()
            ->take(5)
            ->get();

        return response()->json($unread);
    }
}
