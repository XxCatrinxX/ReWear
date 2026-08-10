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
        $paymentMethods = $user->paymentMethods()->get();
        return view('seller.membership', compact('user', 'paymentMethods'));
    }

    /**
     * Activa la membresía premium del vendedor.
     */
    public function activate(Request $request)
    {
        $user = $request->user();

        if (!$user->is_seller) {
            return back()->with('error', 'Solo los vendedores pueden contratar una membresía.');
        }

        // Si usó una tarjeta guardada
        if ($request->filled('saved_payment_method_id')) {
            $savedCard = $user->paymentMethods()->find($request->input('saved_payment_method_id'));
            if (!$savedCard) {
                return back()->with('error', 'El método de pago guardado seleccionado no existe.');
            }
        } else {
            // Si no tiene tarjeta guardada o eligió ingresar una nueva, validar campos obligatorios
            $request->validate([
                'card_number' => ['required', 'string', 'min:12', 'max:20'],
                'card_holder' => ['required', 'string', 'max:150'],
                'card_expiry' => ['required', 'string', 'max:5'],
                'card_cvv'    => ['required', 'string', 'min:3', 'max:4'],
            ], [
                'card_number.required' => 'El número de tarjeta es obligatorio para activar el plan Premium.',
                'card_holder.required' => 'El nombre del titular es obligatorio.',
                'card_expiry.required' => 'La fecha de expiración es obligatoria.',
                'card_cvv.required'    => 'El código CVV es obligatorio.',
            ]);

            // Guardar si eligió recordar tarjeta
            if ($request->boolean('save_card')) {
                $cleanCardNum = preg_replace('/\s+/', '', $request->card_number);
                $lastFour = substr($cleanCardNum, -4);
                $brand = $request->input('card_brand', 'Visa');

                $user->paymentMethods()->firstOrCreate([
                    'last_four' => $lastFour,
                    'card_type' => $request->input('card_type', 'credito'),
                ], [
                    'card_brand'       => $brand !== 'Desconocido' ? $brand : 'Visa',
                    'bank_name'        => $request->input('bank_name', 'Banco Emisor'),
                    'cardholder_name'  => $request->card_holder,
                    'expiration'       => $request->card_expiry,
                    'is_default'       => $user->paymentMethods()->count() == 0,
                ]);
            }
        }

        // Extiende 1 mes si ya tiene membresía activa, o desde hoy si no la tiene
        $base = ($user->membership_expires_at && $user->membership_expires_at->isFuture())
            ? $user->membership_expires_at
            : now();

        $user->update([
            'is_premium_seller'     => true,
            'membership_expires_at' => $base->addMonth(),
        ]);

        return back()->with('success', '¡Membresía Premium activada exitosamente por 30 días!');
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
