<x-guest-layout>
    <div class="w-full">
        <div class="text-center mb-8 hidden lg:block">
            <h2 class="font-outfit text-3xl font-bold text-[#263238]">
                Crea tu cuenta
            </h2>
            <p class="mt-2 text-[#607D8B]">
                Únete a la comunidad de moda circular más grande de México
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 bg-white p-8 rounded-3xl shadow-soft border border-[#E5E7EB]">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-[#263238] mb-1">Nombre completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="input w-full" placeholder="Tu nombre">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#263238] mb-1">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="input w-full" placeholder="tucorreo@ejemplo.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-[#263238] mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="input w-full" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-[#263238] mb-1">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="input w-full" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-primary w-full justify-center text-lg shadow-md">
                    Registrarse
                </button>
            </div>
            
            <div class="mt-6 text-center text-sm text-[#607D8B]">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-bold text-[#D4A373] hover:text-[#b88c63] transition-colors">
                    Inicia sesión
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>