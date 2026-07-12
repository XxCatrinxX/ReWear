<x-guest-layout>

    <div class="w-full max-w-md">

        <x-rewear.card>

            <div class="text-center">

                <x-rewear.logo />

                <h2 class="mt-8 text-3xl font-bold text-gray-800">
                    Bienvenido de nuevo
                </h2>

                <p class="mt-2 text-gray-500">
                    Ingresa tus credenciales para acceder a tu cuenta
                </p>

            </div>

            <x-auth-session-status
                class="mt-6"
                :status="session('status')" />

            <form
                method="POST"
                action="{{ route('login') }}"
                class="mt-8 space-y-6">

                @csrf

                <div>

                    <x-rewear.label
                        for="email"
                        value="Email Address" />

                    <x-rewear.input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"/>

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"/>

                </div>

                <div>

                    <x-rewear.label
                        for="password"
                        value="Password"/>

                    <x-rewear.input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"/>

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"/>

                </div>

                <div class="flex items-center justify-between">

                    <label class="flex items-center gap-2">

                        <x-rewear.checkbox
                            name="remember"/>

                        <span class="text-sm text-gray-600">

                            Recordarme

                        </span>

                    </label>

                    @if(Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-green-700 hover:underline">

                            ¿Olvidaste tu contraseña?

                        </a>

                    @endif

                </div>

                <x-rewear.button>

                    Iniciar sesión

                </x-rewear.button>

            </form>

            <div class="mt-8 text-center">

                <span class="text-gray-500">

                    ¿No tienes una cuenta?

                </span>

                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-green-700 hover:underline">

                    Crear cuenta

                </a>

            </div>

        </x-rewear.card>

    </div>

</x-guest-layout>