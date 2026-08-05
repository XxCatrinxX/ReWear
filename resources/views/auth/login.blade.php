<x-guest-layout>
    <div class="w-full">
        <div class="text-center mb-8 hidden lg:block">
            <h2 class="font-outfit text-3xl font-bold text-[#263238]">
                ¡Bienvenido de nuevo!
            </h2>
            <p class="mt-2 text-[#607D8B]">
                Ingresa tus credenciales para acceder a tu cuenta
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5 bg-white p-8 rounded-3xl shadow-soft border border-[#E5E7EB]">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#263238] mb-1">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="input w-full" placeholder="tucorreo@ejemplo.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-[#263238] mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="input w-full" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-[#2E7D32] shadow-sm focus:ring-[#2E7D32]">
                    <span class="ml-2 text-sm text-[#607D8B]">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-[#2E7D32] hover:text-[#1B5E20] font-medium transition-colors" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-primary w-full justify-center text-lg shadow-md">
                    Iniciar Sesión
                </button>
            </div>
            
            <div class="mt-6 text-center text-sm text-[#607D8B]">
                ¿No tienes una cuenta? 
                <a href="{{ route('register') }}" class="font-bold text-[#D4A373] hover:text-[#b88c63] transition-colors">
                    Regístrate aquí
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>