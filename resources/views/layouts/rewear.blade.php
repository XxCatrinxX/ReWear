<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Meta Tags & Icons -->
    <meta name="theme-color" content="#2E7D32">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ReWear">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/pwa/icon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/images/pwa/icon-512.png">
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="apple-touch-icon" href="/images/pwa/icon-192.png">

    <title>{{ config('app.name', 'ReWear') }} - @yield('title', 'Marketplace de ropa de segunda mano')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F8FAF7] text-[#263238] min-h-screen flex flex-col selection:bg-[#D4A373] selection:text-white pb-20 md:pb-0 overflow-x-hidden w-full">
    
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#E5E7EB] shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo & Nav Links -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        @if(file_exists(public_path('images/rewear1.png')))
                            <img src="{{ asset('images/rewear1.png') }}" class="w-10 h-10 object-contain rounded-xl shadow-soft" alt="ReWear">
                        @else
                            <div class="w-10 h-10 bg-[#2E7D32] rounded-xl flex items-center justify-center text-white font-outfit font-bold text-xl group-hover:bg-[#1B5E20] transition-colors shadow-soft">RW</div>
                        @endif
                        <span class="font-outfit font-bold text-2xl tracking-tight text-[#2E7D32]">ReWear</span>
                    </a>
                    
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('catalog') }}" class="text-[#607D8B] hover:text-[#2E7D32] font-medium transition-colors">Catálogo</a>
                        <a href="{{ route('catalog', ['sort' => 'latest']) }}" class="text-[#607D8B] hover:text-[#2E7D32] font-medium transition-colors">Novedades</a>
                        <a href="{{ route('home') }}#como-funciona" class="text-[#607D8B] hover:text-[#2E7D32] font-medium transition-colors">¿Cómo Funciona?</a>
                    </div>
                </div>

                <!-- Search bar -->
                <div class="hidden md:flex flex-1 max-w-lg items-center px-8">
                    <form action="{{ route('catalog') }}" method="GET" class="w-full relative">
                        <input type="text" name="search" placeholder="Busca marcas, estilos o prendas..." 
                            class="w-full bg-[#F8FAF7] border-transparent rounded-full py-2.5 pl-12 pr-4 focus:border-[#2E7D32] focus:bg-white focus:ring focus:ring-[#2E7D32]/20 transition-all text-sm"
                            value="{{ request('search') }}">
                        <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-xl text-[#607D8B]'></i>
                    </form>
                </div>

                <!-- Actions -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('seller.products.create') }}" class="text-sm font-medium text-[#D4A373] hover:text-[#b88c63] transition-colors border border-[#D4A373] px-4 py-2 rounded-full hover:bg-[#D4A373]/10">
                            Vender ropa
                        </a>
                        
                        <a href="{{ route('favorites.index') }}" class="p-2 text-[#607D8B] hover:text-[#D4A373] transition-colors relative">
                            <i class='bx bx-heart text-2xl'></i>
                        </a>

                        <a href="{{ route('cart.index') }}" class="p-2 text-[#607D8B] hover:text-[#2E7D32] transition-colors relative">
                            <i class='bx bx-shopping-bag text-2xl'></i>
                            @php
                                $cartCount = auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute top-0 right-0 w-5 h-5 bg-[#D4A373] text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Notificaciones -->
                        @auth
                            @php
                                $unreadNotifs = auth()->user()->unreadNotificationsCount();
                            @endphp
                            <a href="{{ route('notifications.index') }}" class="p-2 text-[#607D8B] hover:text-[#2E7D32] transition-colors relative" title="Notificaciones">
                                <i class='bx bx-bell text-2xl'></i>
                                @if($unreadNotifs > 0)
                                    <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white animate-pulse">
                                        {{ $unreadNotifs > 99 ? '99+' : $unreadNotifs }}
                                    </span>
                                @endif
                            </a>
                        @endauth

                        <!-- User Dropdown -->
                        <div class="relative ml-2" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                                <img class="w-10 h-10 rounded-full object-cover border-2 border-[#E5E7EB] hover:border-[#2E7D32] transition-colors" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                            </button>
                            
                            <div x-show="open" x-transition.origin.top.right style="display: none;" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-card py-2 border border-[#E5E7EB]">
                                <div class="px-4 py-3 border-b border-[#E5E7EB]">
                                    <p class="text-sm font-medium text-[#263238] truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-[#607D8B] truncate">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]"><i class='bx bx-grid-alt mr-2'></i> Mi Panel</a>
                                <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-4 py-2.5 text-sm text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]">
                                    <span><i class='bx bx-bell mr-2'></i> Notificaciones</span>
                                    @if(auth()->user()->unreadNotificationsCount() > 0)
                                        <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ auth()->user()->unreadNotificationsCount() }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]"><i class='bx bx-package mr-2'></i> Mis Compras</a>
                                @if(auth()->user()->isSeller())
                                    <a href="{{ route('seller.orders.index') }}" class="block px-4 py-2.5 text-sm text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]"><i class='bx bx-store-alt mr-2'></i> Mis Ventas</a>
                                    <a href="{{ route('seller.wallet.index') }}" class="block px-4 py-2.5 text-sm text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]"><i class='bx bx-wallet-alt mr-2'></i> Mi Billetera</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]"><i class='bx bx-user mr-2'></i> Configuración</a>
                                
                                <div class="border-t border-[#E5E7EB] my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-[#E53935] hover:bg-[#fff2f2] transition-colors"><i class='bx bx-log-out mr-2'></i> Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-[#607D8B] hover:text-[#2E7D32] font-medium px-2 py-2">Ingresar</a>
                        <a href="{{ route('register') }}" class="bg-[#2E7D32] text-white font-medium px-5 py-2.5 rounded-full hover:bg-[#1B5E20] transition-colors shadow-soft">Registrarse</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden gap-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="p-2 text-[#607D8B] relative">
                            <i class='bx bx-shopping-bag text-2xl'></i>
                            @php $cartCountMobile = auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0; @endphp
                            @if($cartCountMobile > 0)
                                <span class="absolute top-0 right-0 w-4 h-4 bg-[#D4A373] text-white text-[9px] font-bold flex items-center justify-center rounded-full">
                                    {{ $cartCountMobile }}
                                </span>
                            @endif
                        </a>
                    @endauth
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-[#263238] hover:text-[#2E7D32] focus:outline-none">
                        <i class='bx bx-menu text-3xl' x-show="!mobileMenuOpen"></i>
                        <i class='bx bx-x text-3xl' x-show="mobileMenuOpen" style="display:none;"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Search -->
            <div class="md:hidden pb-4">
                <form action="{{ route('catalog') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" placeholder="Buscar..." class="w-full bg-[#F8FAF7] border-transparent rounded-full py-2.5 pl-10 pr-4 focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 text-sm" value="{{ request('search') }}">
                    <i class='bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-lg text-[#607D8B]'></i>
                </form>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display:none;" class="md:hidden border-t border-[#E5E7EB] bg-white absolute w-full left-0 shadow-card">
            <div class="px-4 py-2 space-y-1">
                <a href="{{ route('catalog') }}" class="block px-3 py-3 rounded-md text-base font-medium text-[#263238] hover:bg-[#F8FAF7] hover:text-[#2E7D32]">Catálogo</a>
                <a href="{{ route('catalog', ['sort' => 'latest']) }}" class="block px-3 py-3 rounded-md text-base font-medium text-[#263238] hover:bg-[#F8FAF7] hover:text-[#2E7D32]">Novedades</a>
                <a href="{{ route('home') }}#como-funciona" class="block px-3 py-3 rounded-md text-base font-medium text-[#263238] hover:bg-[#F8FAF7] hover:text-[#2E7D32]">¿Cómo Funciona?</a>
            </div>
            @auth
                <div class="pt-4 pb-3 border-t border-[#E5E7EB]">
                    <div class="flex items-center px-4 mb-3">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}" alt="">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-[#263238]">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-[#607D8B]">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="space-y-1 px-2">
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]">Mi Panel</a>
                        <a href="{{ route('seller.products.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-[#D4A373] hover:bg-[#F8FAF7]">Vender Ropa</a>
                        <a href="{{ route('favorites.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-[#607D8B] hover:bg-[#F8FAF7]">Favoritos</a>
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-[#607D8B] hover:bg-[#F8FAF7]">Configuración</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-[#E53935] hover:bg-[#fff2f2]">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="pt-4 pb-4 border-t border-[#E5E7EB] px-4 space-y-3">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-[#E5E7EB] rounded-full text-base font-medium text-[#263238] hover:bg-[#F8FAF7]">Ingresar</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-full shadow-soft text-base font-medium text-white bg-[#2E7D32] hover:bg-[#1B5E20]">Registrarse</a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-[#43A047]/10 border border-[#43A047]/20 text-[#2E7D32] px-4 py-3 rounded-xl flex items-center gap-3">
                    <i class='bx bxs-check-circle text-xl'></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-[#E53935]/10 border border-[#E53935]/20 text-[#C62828] px-4 py-3 rounded-xl flex items-center gap-3">
                    <i class='bx bxs-error-circle text-xl'></i>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-blue-50 border border-blue-100 text-blue-800 px-4 py-3 rounded-xl flex items-center gap-3">
                    <i class='bx bxs-info-circle text-xl'></i>
                    <p class="font-medium text-sm">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#E5E7EB] mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        @if(file_exists(public_path('images/rewear1.png')))
                            <img src="{{ asset('images/rewear1.png') }}" class="w-8 h-8 object-contain rounded-lg" alt="ReWear">
                        @else
                            <div class="w-8 h-8 bg-[#2E7D32] rounded-lg flex items-center justify-center text-white font-outfit font-bold text-lg">RW</div>
                        @endif
                        <span class="font-outfit font-bold text-xl tracking-tight text-[#2E7D32]">ReWear</span>
                    </a>
                    <p class="text-sm text-[#607D8B] mb-6">El marketplace de moda circular donde puedes comprar y vender ropa de segunda mano con estilo y seguridad.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-[#607D8B] hover:text-[#2E7D32] text-xl transition-colors"><i class='bx bxl-instagram'></i></a>
                        <a href="#" class="text-[#607D8B] hover:text-[#2E7D32] text-xl transition-colors"><i class='bx bxl-tiktok'></i></a>
                        <a href="#" class="text-[#607D8B] hover:text-[#2E7D32] text-xl transition-colors"><i class='bx bxl-facebook'></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-outfit font-semibold text-[#263238] mb-4">Comprar</h3>
                    <ul class="space-y-3 text-sm text-[#607D8B]">
                        <li><a href="{{ route('catalog') }}" class="hover:text-[#2E7D32] transition-colors">Catálogo</a></li>
                        <li><a href="{{ route('catalog', ['sort' => 'latest']) }}" class="hover:text-[#2E7D32] transition-colors">Novedades</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'how-it-works']) }}" class="hover:text-[#2E7D32] transition-colors">¿Cómo funciona?</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'shipping']) }}" class="hover:text-[#2E7D32] transition-colors">Envíos y Entregas</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-outfit font-semibold text-[#263238] mb-4">Vender</h3>
                    <ul class="space-y-3 text-sm text-[#607D8B]">
                        <li><a href="{{ route('footer.show', ['page' => 'how-to-sell']) }}" class="hover:text-[#2E7D32] transition-colors">¿Cómo vender?</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'seller-guide']) }}" class="hover:text-[#2E7D32] transition-colors">Guía del vendedor</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'fees']) }}" class="hover:text-[#2E7D32] transition-colors">Comisiones y tarifas</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'returns']) }}" class="hover:text-[#2E7D32] transition-colors">Política de devoluciones</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-outfit font-semibold text-[#263238] mb-4">Ayuda</h3>
                    <ul class="space-y-3 text-sm text-[#607D8B]">
                        <li><a href="{{ route('footer.show', ['page' => 'faq']) }}" class="hover:text-[#2E7D32] transition-colors">Preguntas Frecuentes</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'contact']) }}" class="hover:text-[#2E7D32] transition-colors">Contacto</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'privacy']) }}" class="hover:text-[#2E7D32] transition-colors">Privacidad</a></li>
                        <li><a href="{{ route('footer.show', ['page' => 'terms']) }}" class="hover:text-[#2E7D32] transition-colors">Términos y Condiciones</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-[#E5E7EB] mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-[#607D8B]">© {{ date('Y') }} ReWear. Todos los derechos reservados.</p>
                <div class="flex space-x-6 text-sm text-[#607D8B]">
                    <a href="{{ route('footer.show', ['page' => 'terms']) }}" class="hover:text-[#2E7D32] transition-colors">Términos y Condiciones</a>
                    <a href="{{ route('footer.show', ['page' => 'privacy']) }}" class="hover:text-[#2E7D32] transition-colors">Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ───────────────── BARRA NAVEGACIÓN INFERIOR MÓVIL (ANDROID / PWA) ───────────────── -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg border-t border-[#E5E7EB] px-1 py-1 shadow-card flex justify-between items-center text-[10px] w-full max-w-full overflow-hidden">
        <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-medium min-w-0 {{ request()->routeIs('home') ? 'text-[#2E7D32]' : 'text-[#607D8B]' }}">
            <i class='bx {{ request()->routeIs('home') ? 'bxs-home' : 'bx-home' }} text-xl mb-0.5'></i>
            <span class="truncate max-w-full">Inicio</span>
        </a>

        <a href="{{ route('catalog') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-medium min-w-0 {{ request()->routeIs('catalog*') ? 'text-[#2E7D32]' : 'text-[#607D8B]' }}">
            <i class='bx {{ request()->routeIs('catalog*') ? 'bxs-store' : 'bx-store' }} text-xl mb-0.5'></i>
            <span class="truncate max-w-full">Catálogo</span>
        </a>

        @auth
            <a href="{{ route('orders.index') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-medium min-w-0 {{ request()->routeIs('orders*') && !request()->routeIs('seller.orders*') ? 'text-[#2E7D32]' : 'text-[#607D8B]' }}">
                <i class='bx {{ request()->routeIs('orders*') && !request()->routeIs('seller.orders*') ? 'bxs-package' : 'bx-package' }} text-xl mb-0.5'></i>
                <span class="truncate max-w-full">Compras</span>
            </a>

            @if(auth()->user()->isSeller())
                <a href="{{ route('seller.dashboard') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-semibold text-[#D4A373] min-w-0">
                    <div class="w-8 h-8 -mt-3 bg-[#D4A373] text-white rounded-full flex items-center justify-center shadow-md border-2 border-white">
                        <i class='bx bx-store-alt text-base'></i>
                    </div>
                    <span class="mt-0.5 truncate max-w-full">Ventas</span>
                </a>
            @else
                <a href="{{ route('seller.products.create') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-semibold text-[#D4A373] min-w-0">
                    <div class="w-8 h-8 -mt-3 bg-[#D4A373] text-white rounded-full flex items-center justify-center shadow-md border-2 border-white">
                        <i class='bx bx-plus text-base'></i>
                    </div>
                    <span class="mt-0.5 truncate max-w-full">Vender</span>
                </a>
            @endif

            <a href="{{ route('dashboard') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-medium min-w-0 {{ request()->routeIs('dashboard', 'profile*') ? 'text-[#2E7D32]' : 'text-[#607D8B]' }}">
                <i class='bx {{ request()->routeIs('dashboard', 'profile*') ? 'bxs-user' : 'bx-user' }} text-xl mb-0.5'></i>
                <span class="truncate max-w-full">Mi Cuenta</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex-1 flex flex-col items-center py-1 px-1 font-medium text-[#2E7D32] min-w-0">
                <i class='bx bx-log-in text-xl mb-0.5'></i>
                <span class="truncate max-w-full">Ingresar</span>
            </a>
        @endauth
    </nav>

    <!-- Banner de Instalación PWA (Android / Mobile) -->
    <div id="pwa-install-banner" class="hidden fixed bottom-16 left-4 right-4 z-50 bg-[#263238] text-white p-4 rounded-2xl shadow-xl flex items-center justify-between gap-3 border border-white/10 md:hidden">
        <div class="flex items-center gap-3">
            @if(file_exists(public_path('images/rewear1.png')))
                <img src="{{ asset('images/rewear1.png') }}" class="w-10 h-10 object-contain rounded-xl flex-shrink-0" alt="ReWear">
            @else
                <div class="w-10 h-10 bg-[#2E7D32] rounded-xl flex items-center justify-center font-bold text-lg text-white flex-shrink-0">
                    RW
                </div>
            @endif
            <div>
                <p class="font-bold text-sm leading-tight">Instalar ReWear App</p>
                <p class="text-xs text-gray-300">Acceso rápido desde tu pantalla principal</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button id="pwa-install-btn" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white px-3 py-1.5 rounded-xl text-xs font-bold transition">
                Instalar
            </button>
            <button id="pwa-close-btn" class="text-gray-400 hover:text-white p-1">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
    </div>

    @stack('scripts')

    <!-- Registro de Service Worker PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registrado con éxito en scope:', registration.scope);
                }, function(err) {
                    console.log('Error en registro de ServiceWorker:', err);
                });
            });
        }

        // Manejo del banner de instalación PWA en Android
        let deferredPrompt;
        const installBanner = document.getElementById('pwa-install-banner');
        const installBtn = document.getElementById('pwa-install-btn');
        const closeBtn = document.getElementById('pwa-close-btn');

        @auth
            // Al iniciar sesión, resetear el estado cerrado del banner para mostrarlo de nuevo
            sessionStorage.removeItem('pwa_banner_dismissed');
        @endauth

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (installBanner && !sessionStorage.getItem('pwa_banner_dismissed')) {
                installBanner.classList.remove('hidden');
            }
        });

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`PWA Prompt outcome: ${outcome}`);
                    deferredPrompt = null;
                }
                installBanner.classList.add('hidden');
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                installBanner.classList.add('hidden');
                sessionStorage.setItem('pwa_banner_dismissed', 'true');
            });
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
