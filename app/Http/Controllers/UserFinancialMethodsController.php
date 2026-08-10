<?php

namespace App\Http\Controllers;

use App\Models\UserPaymentMethod;
use App\Models\UserBankMethod;
use Illuminate\Http\Request;

class UserFinancialMethodsController extends Controller
{
    /**
     * Guarda un nuevo método de pago (Tarjeta).
     */
    public function storePaymentMethod(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'card_type'       => ['required', 'string', 'in:credito,debito'],
            'card_number'     => ['required', 'string', 'min:12', 'max:20'],
            'cardholder_name' => ['required', 'string', 'max:150'],
            'expiration'      => ['required', 'string', 'max:5'],
            'bank_name'       => ['nullable', 'string', 'max:100'],
            'card_brand'      => ['nullable', 'string', 'max:50'],
        ]);

        $cleanNum = preg_replace('/\s+/', '', $request->card_number);
        $lastFour = substr($cleanNum, -4);
        $brand = $request->input('card_brand') ?: 'Visa';
        $bank = $request->input('bank_name') ?: 'Banco Emisor';

        $user->paymentMethods()->create([
            'card_type'       => $request->card_type,
            'card_brand'      => $brand !== 'Desconocido' ? $brand : 'Visa',
            'bank_name'       => $bank !== 'Desconocido' ? $bank : 'Banco Emisor',
            'cardholder_name' => $request->cardholder_name,
            'last_four'       => $lastFour,
            'expiration'      => $request->expiration,
            'is_default'      => $user->paymentMethods()->count() == 0,
        ]);

        return back()->with('success', '¡Tarjeta guardada correctamente!');
    }

    /**
     * Elimina un método de pago.
     */
    public function destroyPaymentMethod(Request $request, UserPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== $request->user()->id) {
            abort(403);
        }

        $paymentMethod->delete();
        return back()->with('success', 'Método de pago eliminado correctamente.');
    }

    /**
     * Guarda una nueva cuenta bancaria (CLABE).
     */
    public function storeBankMethod(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'clabe'          => ['required', 'string', 'digits:18'],
            'bank_name'      => ['required', 'string', 'max:100'],
            'account_holder' => ['required', 'string', 'max:150'],
        ]);

        $user->bankMethods()->create([
            'bank_name'      => $request->bank_name,
            'clabe'          => $request->clabe,
            'account_holder' => $request->account_holder,
            'is_default'     => $user->bankMethods()->count() == 0,
        ]);

        return back()->with('success', '¡Cuenta bancaria guardada correctamente!');
    }

    /**
     * Elimina una cuenta bancaria.
     */
    public function destroyBankMethod(Request $request, UserBankMethod $bankMethod)
    {
        if ($bankMethod->user_id !== $request->user()->id) {
            abort(403);
        }

        $bankMethod->delete();
        return back()->with('success', 'Cuenta bancaria eliminada correctamente.');
    }
}
