<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'ReWear') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans bg-gradient-to-br from-slate-50 via-white to-green-50">

    <div class="min-h-screen lg:grid lg:grid-cols-2">

        <!-- ========================================= -->
        <!-- LEFT PANEL -->
        <!-- ========================================= -->

        <section class="relative hidden lg:flex overflow-hidden">

            <!-- Background Image -->

            <img
                src="{{ asset('images/fondo ropa.jpg') }}"
                alt="ReWear"
                class="absolute inset-0 h-full w-full object-cover scale-105">

            <!-- Overlay -->

            <div
                class="absolute inset-0 bg-gradient-to-br from-green-950/90 via-green-900/75 to-black/50">
            </div>

            <!-- Decorative circles -->

            <div
                class="absolute -top-24 -right-24 h-80 w-80 rounded-full bg-white/10 blur-3xl">
            </div>

            <div
                class="absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-green-400/20 blur-3xl">
            </div>

            <!-- Content -->

            <div
                class="relative z-10 flex h-full w-full flex-col justify-between px-20 py-16 text-white">

                <!-- Logo -->

                <div>

                    <h1 class="text-6xl font-extrabold tracking-tight">

                        ♻ ReWear

                    </h1>

                    <p class="mt-8 max-w-lg text-2xl leading-relaxed text-green-100">

                        La moda sostenible al alcance de todos.

                    </p>

                    <p class="mt-4 max-w-lg text-lg text-green-200">

                        Compra, vende o intercambia ropa con personas de todo México.

                    </p>

                </div>

                <!-- Benefits -->

                <div class="space-y-5">

                    <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">

                        🌱 <strong>Moda Sostenible</strong>

                        <p class="mt-2 text-green-100">

                            Reduce, reutiliza y recicla ropa para cuidar el medio ambiente.

                        </p>

                    </div>

                    <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">

                        👕 <strong>Marketplace</strong>

                        <p class="mt-2 text-green-100">

                            Compra, vende o intercambia ropa de manera segura.

                        </p>

                    </div>

                    <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">

                        💬 <strong>Negociación Directa</strong>

                        <p class="mt-2 text-green-100">

                            Comunícate directamente con otros usuarios para cerrar tratos.

                        </p>

                    </div>

                    <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm">

                        🚚 <strong>Envío a través de México</strong>

                        <p class="mt-2 text-green-100">

                            Entrega local o envío nacional.

                        </p>

                    </div>

                </div>

                <!-- Stats -->

                <div>

                    <div class="grid grid-cols-4 gap-8">

                        <div>

                            <h3 class="text-3xl font-bold">

                                12K+

                            </h3>

                            <p class="text-green-200">

                                Usuarios

                            </p>

                        </div>

                        <div>

                            <h3 class="text-3xl font-bold">

                                8K+

                            </h3>

                            <p class="text-green-200">

                                Piezas de Ropa

                            </p>

                        </div>

                        <div>

                            <h3 class="text-3xl font-bold">

                                32

                            </h3>

                            <p class="text-green-200">

                                Estados

                            </p>

                        </div>

                        <div>

                            <h3 class="text-3xl font-bold">

                                95%

                            </h3>

                            <p class="text-green-200">

                                Reseñas Positivas

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!-- ========================================= -->
        <!-- RIGHT PANEL -->
        <!-- ========================================= -->

        <section class="flex items-center justify-center px-6 py-12">

            <div class="w-full max-w-lg">

                <!-- Mobile Logo -->

                <div class="mb-10 text-center lg:hidden">

                    <h1 class="text-5xl font-extrabold text-primary">

                        ♻ ReWear

                    </h1>

                    <p class="mt-4 text-lg text-gray-500">

                        Marketplace de Moda Sostenible

                    </p>

                </div>

                <!-- Login Card -->

                <div class="rounded-2xl p-8 ">

                    {{ $slot }}

                </div>

                <!-- Footer -->

                <p class="mt-8 text-center text-sm text-gray-500">

                    © {{ date('Y') }} ReWear

                    • Sustainable Fashion Marketplace

                </p>

            </div>

        </section>

    </div>

</body>

</html>