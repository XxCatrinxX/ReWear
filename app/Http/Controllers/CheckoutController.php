<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService
    ) {}

    /**
     * Muestra la página de checkout.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $this->cartService->getCartWithItems($user);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('info', 'Tu carrito está vacío.');
        }

        $addresses = $user->addresses()->get();
        $paymentMethods = $user->paymentMethods()->get();
        return view('checkout.index', compact('cart', 'addresses', 'paymentMethods'));
    }

    /**
     * Procesa la compra.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $rules = [
            'notes'       => ['nullable', 'string', 'max:500'],
            'card_type'   => ['required', 'string', 'in:credito,debito'],
            'bank_name'   => ['required', 'string', 'max:100'],
            'card_number' => ['required', 'string', 'min:12', 'max:20'],
            'card_holder' => ['required', 'string', 'max:150'],
            'card_expiry' => ['required', 'string', 'max:5'],
            'card_cvv'    => ['required', 'string', 'min:3', 'max:4'],
        ];

        $hasAddresses    = $user->addresses()->exists();
        $addressIdSent   = $request->filled('address_id') && $request->address_id !== 'null';
        $newAddressMode  = $request->boolean('new_address') || !$hasAddresses || (!$addressIdSent && $hasAddresses && $request->filled('street'));

        if ($addressIdSent) {
            // Usar dirección existente
            $rules['address_id'] = ['required', 'integer', 'exists:addresses,id'];
        } elseif ($hasAddresses && !$newAddressMode) {
            // Tiene direcciones pero no seleccionó ninguna y no llenó formulario nuevo
            return redirect()->back()
                ->withInput()
                ->withErrors(['address_id' => 'Por favor selecciona una dirección de envío o registra una nueva.']);
        } else {
            // Nueva dirección
            $rules['label']           = ['required', 'string', 'max:50'];
            $rules['recipient_name']  = ['required', 'string', 'max:150'];
            $rules['phone']           = ['required', 'string', 'max:20'];
            $rules['street']          = ['required', 'string', 'max:200'];
            $rules['exterior_number'] = ['required', 'string', 'max:20'];
            $rules['interior_number'] = ['nullable', 'string', 'max:20'];
            $rules['neighborhood']    = ['required', 'string', 'max:100'];
            $rules['postal_code']     = ['required', 'string', 'max:10'];
            $rules['city']            = ['required', 'string', 'max:100'];
            $rules['state']           = ['required', 'string', 'max:100'];
        }

        $validated = $request->validate($rules);

        try {
            $addressId = $request->address_id;
            if (!$addressId || $addressId === 'null') {
                $newAddress = $user->addresses()->create([
                    'label'           => $request->label,
                    'recipient_name'  => $request->recipient_name,
                    'phone'           => $request->phone,
                    'street'          => $request->street,
                    'exterior_number' => $request->exterior_number,
                    'interior_number' => $request->interior_number,
                    'neighborhood'    => $request->neighborhood,
                    'postal_code'     => $request->postal_code,
                    'city'            => $request->city,
                    'state'           => $request->state,
                    'country'         => 'México',
                    'is_default'      => $user->addresses()->count() == 0,
                ]);
                $addressId = $newAddress->id;
            }

            // Si seleccionó la casilla para guardar la tarjeta
            if ($request->boolean('save_card')) {
                $cleanCardNum = preg_replace('/\s+/', '', $request->card_number);
                $lastFour = substr($cleanCardNum, -4);
                $brand = $request->input('card_brand', 'Visa');

                // Evitar duplicados
                $user->paymentMethods()->firstOrCreate([
                    'last_four' => $lastFour,
                    'card_type' => $request->card_type,
                ], [
                    'card_brand'       => $brand !== 'Desconocido' ? $brand : 'Visa',
                    'bank_name'        => $request->bank_name !== 'Desconocido' ? $request->bank_name : 'Banco Emisor',
                    'cardholder_name'  => $request->card_holder,
                    'expiration'       => $request->card_expiry,
                    'is_default'       => $user->paymentMethods()->count() == 0,
                ]);
            }

            $order = $this->checkoutService->process(
                $user,
                (int) $addressId,
                $request->input('notes') ?? '',
                [
                    'card_type' => $request->card_type,
                    'bank_name' => $request->bank_name,
                ]
            );

            return redirect()->route('checkout.success', $order)->with('success', '¡Compra realizada con éxito!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Muestra la página de éxito.
     */
    public function success(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['items', 'payment', 'address']);
        return view('checkout.success', compact('order'));
    }
}
