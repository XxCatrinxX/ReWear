<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        // No se puede desactivar al propio admin
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes cambiar tu propio estado.');
        }

        $user->update(['status' => !$user->status]);
        $status = $user->status ? 'activado' : 'desactivado';
        
        return back()->with('success', "Usuario {$status} correctamente.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $user->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleMembership(User $user)
    {
        if ($user->hasPremiumMembership()) {
            $user->update([
                'is_premium_seller'     => false,
                'membership_expires_at' => null,
            ]);
            return back()->with('success', 'Membresía Premium revocada al usuario.');
        }

        $user->update([
            'is_premium_seller'     => true,
            'membership_expires_at' => now()->addMonth(),
        ]);
        return back()->with('success', 'Membresía Premium otorgada al usuario por 30 días.');
    }
}
