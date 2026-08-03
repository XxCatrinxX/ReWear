<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderMessage;
use Illuminate\Http\Request;

class OrderMessageController extends Controller
{
    /**
     * Devuelve los mensajes de un pedido en JSON (para polling).
     * Accesible por el comprador y el vendedor del pedido.
     */
    public function index(Request $request, Order $order)
    {
        $this->authorizeChat($request, $order);

        // Marcar como leídos los mensajes del otro usuario
        $order->messages()
            ->where('user_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $order->messages()->with('user:id,name')->get()->map(function ($msg) use ($request) {
            return [
                'id'          => $msg->id,
                'message'     => $msg->message,
                'sender_role' => $msg->sender_role,
                'sender_name' => $msg->user->name,
                'is_mine'     => $msg->user_id === $request->user()->id,
                'time'        => $msg->created_at->format('H:i'),
                'date'        => $msg->created_at->isoFormat('D MMM'),
            ];
        });

        return response()->json([
            'messages'       => $messages,
            'unread_count'   => $order->messages()
                                    ->where('user_id', '!=', $request->user()->id)
                                    ->whereNull('read_at')
                                    ->count(),
        ]);
    }

    /**
     * Guarda un nuevo mensaje en el pedido.
     */
    public function store(Request $request, Order $order)
    {
        $this->authorizeChat($request, $order);

        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $user = $request->user();

        // Determinar rol del remitente
        $role = $order->buyer_id === $user->id ? 'buyer' : 'seller';

        $msg = $order->messages()->create([
            'user_id'     => $user->id,
            'sender_role' => $role,
            'message'     => $request->message,
        ]);

        return response()->json([
            'id'          => $msg->id,
            'message'     => $msg->message,
            'sender_role' => $msg->sender_role,
            'sender_name' => $user->name,
            'is_mine'     => true,
            'time'        => $msg->created_at->format('H:i'),
            'date'        => $msg->created_at->isoFormat('D MMM'),
        ], 201);
    }

    /**
     * Verifica que el usuario autenticado sea el comprador o un vendedor de ese pedido.
     */
    private function authorizeChat(Request $request, Order $order): void
    {
        $user = $request->user();

        $isBuyer  = $order->buyer_id === $user->id;
        $isSeller = $order->items()->where('seller_id', $user->id)->exists();

        if (!$isBuyer && !$isSeller) {
            abort(403, 'No tienes permiso para acceder a este chat.');
        }
    }
}
