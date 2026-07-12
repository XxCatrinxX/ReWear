<x-guest-layout>

    <div class="w-full max-w-md">

        <x-rewear.card>

            <div class="text-center">

                <x-rewear.logo />

                <h2 class="mt-8 text-3xl font-bold text-gray-800">
                    ¿Olvidaste tu contraseña?
                </h2>

                <p class="mt-2 text-gray-500">
                    No te preocupes. Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
                </p>

            </div>

            <x-auth-session-status
                class="mt-6"
                :status="session('status')" />

            <form
                method="POST"
                action="{{ route('password.email') }}"
                class="mt-8 space-y-6">

                @csrf

                <div>

                    <x-rewear.label
                        for="email"
                        value="Correo electrónico" />

                    <x-rewear.input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />

                </div>

                <x-rewear.button>
                    Enviar enlace de recuperación
                </x-rewear.button>

            </form>

            <div class="mt-8 text-center">

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-green-700 hover:underline">
                    Volver al inicio de sesión
                </a>

            </div>

        </x-rewear.card>

    </div>

</x-guest-layout>