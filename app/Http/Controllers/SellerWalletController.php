<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;

class SellerWalletController extends Controller
{
    /**
     * Muestra la billetera del vendedor con sus saldos y formulario de retiro.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $withdrawals = $user->withdrawals()->latest()->paginate(10);

        return view('seller.wallet.index', compact('user', 'withdrawals'));
    }

    /**
     * Procesa una solicitud de retiro de fondos a cuenta bancaria (CLABE).
     */
    public function withdraw(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'amount'    => ['required', 'numeric', 'min:10', 'max:' . $user->available_balance],
            'clabe'     => ['required', 'string', 'digits:18'],
            'bank_name' => ['required', 'string', 'max:100'],
        ], [
            'amount.max' => 'El monto solicitado excede tu saldo disponible para retiro.',
            'amount.min' => 'El monto mínimo de retiro es de $10.00 MXN.',
            'clabe.digits' => 'La CLABE interbancaria debe consistir de exactamente 18 dígitos.',
        ]);

        $amount = (float) $request->input('amount');
        $clabe = $request->input('clabe');
        $bankName = $request->input('bank_name');

        // Guardar CLABE y Banco en el usuario para compras/retiros futuros
        $user->update([
            'clabe' => $clabe,
            'bank_name' => $bankName,
        ]);

        // Descontar del saldo disponible
        $user->decrement('available_balance', $amount);

        // Crear registro de retiro
        Withdrawal::create([
            'user_id'   => $user->id,
            'amount'    => $amount,
            'clabe'     => $clabe,
            'bank_name' => $bankName,
            'status'    => 'completado',
        ]);

        return back()->with('success', '¡Retiro procesado exitosamente! Los fondos han sido transferidos a tu cuenta bancaria.');
    }
}
