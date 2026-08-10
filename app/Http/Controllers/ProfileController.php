<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\StoreAddressRequest;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private ProductService $productService) {}

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        return view('profile.edit', [
            'user'           => $user,
            'paymentMethods' => $user->paymentMethods()->get(),
            'bankMethods'    => $user->bankMethods()->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->fill([
            'name'     => $validated['name'],
            'username' => $validated['username'] ?? $user->username,
            'email'    => $validated['email'],
            'bio'      => $validated['bio'] ?? $user->bio,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            $path = $this->productService->uploadAvatar($request->file('avatar'), $user->id);
            $user->avatar = $path;
        }

        $user->save();

        // Actualizar perfil extendido
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $validated['first_name'] ?? null,
                'last_name'  => $validated['last_name'] ?? null,
                'phone'      => $validated['phone'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'gender'     => $validated['gender'] ?? null,
                'country'    => $validated['country'] ?? null,
                'state'      => $validated['state'] ?? null,
                'city'       => $validated['city'] ?? null,
            ]
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Muestra el formulario para convertirse en vendedor.
     */
    public function showBecomeSellerForm(Request $request)
    {
        $user = $request->user();
        if ($user->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        $address = $user->addresses()->first();
        return view('profile.become-seller', compact('user', 'address'));
    }

    /**
     * Convierte la cuenta actual en vendedor recopilando datos e INE.
     */
    public function becomeSeller(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->isSeller()) {
            return redirect()->route('seller.dashboard');
        }

        $request->validate([
            'label'           => ['required', 'string', 'max:50'],
            'recipient_name'  => ['required', 'string', 'max:150'],
            'phone'           => ['required', 'string', 'max:20'],
            'street'          => ['required', 'string', 'max:200'],
            'exterior_number' => ['required', 'string', 'max:20'],
            'interior_number' => ['nullable', 'string', 'max:20'],
            'neighborhood'    => ['required', 'string', 'max:100'],
            'city'            => ['required', 'string', 'max:100'],
            'state'           => ['required', 'string', 'max:100'],
            'postal_code'     => ['required', 'string', 'max:10'],
            'ine_photo'       => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ], [
            'ine_photo.required' => 'La foto de tu identificación oficial INE es obligatoria.',
            'ine_photo.image'    => 'El archivo debe ser una imagen.',
            'phone.required'     => 'El teléfono de contacto es obligatorio para envíos.',
        ]);

        // Guardar o actualizar la dirección
        $user->addresses()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'label'           => $request->label,
                'recipient_name'  => $request->recipient_name,
                'phone'           => $request->phone,
                'street'          => $request->street,
                'exterior_number' => $request->exterior_number,
                'interior_number' => $request->interior_number,
                'neighborhood'    => $request->neighborhood,
                'city'            => $request->city,
                'state'           => $request->state,
                'postal_code'     => $request->postal_code,
                'country'         => 'México',
                'is_default'      => true,
            ]
        );

        // Guardar foto del INE
        if ($request->hasFile('ine_photo')) {
            $path = $request->file('ine_photo')->store('ines', 'public');
            $user->ine_photo = $path;
        }

        // Activar rol de vendedor
        $user->is_seller = true;
        $user->save();

        return Redirect::route('seller.dashboard')->with('success', '¡Felicidades! Ahora eres un vendedor de ReWear.');
    }

    /**
     * Guarda o actualiza la dirección de envío del usuario.
     */
    public function storeAddress(StoreAddressRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $user->addresses()->updateOrCreate(
            ['user_id' => $user->id], // actualiza si existe una dirección para este usuario, o crea una nueva
            $request->validated()
        );

        return Redirect::route('profile.edit')->with('success', 'Dirección guardada exitosamente.');
    }
}
