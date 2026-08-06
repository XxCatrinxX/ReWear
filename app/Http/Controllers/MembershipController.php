<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /** Página de membresía premium. */
    public function index(Request $request)
    {
        $user = $request->user();
        return view('seller.membership', compact('user'));
    }

    /**
     * Activa la membresía premium del vendedor.
     * En producción real aquí iría la integración con un gateway de pago.
     * Por ahora se activa directamente (sandbox).
     */
    public function activate(Request $request)
    {
        $user = $request->user();

        if (!$user->is_seller) {
            return back()->with('error', 'Solo los vendedores pueden contratar una membresía.');
        }

        // Extiende 1 mes si ya tiene membresía activa, o desde hoy si no la tiene
        $base = ($user->membership_expires_at && $user->membership_expires_at->isFuture())
            ? $user->membership_expires_at
            : now();

        $user->update([
            'is_premium_seller'     => true,
            'membership_expires_at' => $base->addMonth(),
        ]);

        return back()->with('success', '¡Membresía Premium activada por 30 días!');
    }

    /** Cancela/desactiva la membresía premium. */
    public function cancel(Request $request)
    {
        $request->user()->update([
            'is_premium_seller'     => false,
            'membership_expires_at' => null,
        ]);

        return back()->with('success', 'Membresía cancelada. Volverás al plan gratuito (10 publicaciones/mes).');
    }
}
