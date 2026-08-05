<x-guest-layout>

    <div class="w-full max-w-md">

        <x-rewear.card>

            <div class="text-center">

                <x-rewear.logo />

                <h2 class="mt-8 text-3xl font-bold text-gray-800">
                    Crea tu cuenta
                </h2>

                <p class="mt-2 text-gray-500">
                    Regístrate para comenzar a utilizar nuestros servicios
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('register') }}"
                class="mt-8 space-y-6">

                @csrf

                <div>

                    <x-rewear.label
                        for="name"
                        value="Nombre completo" />

                    <x-rewear.input
                        id="name"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name" />

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2" />

                </div>

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
                        autocomplete="username" />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />

                </div>

                <div>

                    <x-rewear.label
                        for="password"
                        value="Contraseña" />

                    <x-rewear.input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2" />

                </div>

                <div>

                    <x-rewear.label
                        for="password_confirmation"
                        value="Confirmar contraseña" />

                    <x-rewear.input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2" />

                </div>

                <x-rewear.button>
                    Registrarse
                </x-rewear.button>

            </form>

            <div class="mt-8 text-center">

                <span class="text-gray-500">
                    ¿Ya tienes una cuenta?
                </span>

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-green-700 hover:underline">
                    Iniciar sesión
                </a>

            </div>

        </x-rewear.card>

    </div>

</x-guest-layout>