<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ReWear') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F8FAF7] text-[#263238] min-h-screen flex selection:bg-[#D4A373] selection:text-white" x-data="{ sidebarOpen: true }">
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-[#E5E7EB] transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
        <div class="flex items-center justify-between h-20 px-6 border-b border-[#E5E7EB]">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#2E7D32] rounded-lg flex items-center justify-center text-white font-outfit font-bold text-lg">RW</div>
                <span class="font-outfit font-bold text-xl tracking-tight text-[#2E7D32]">Admin</span>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-[#607D8B]">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]' }}">
                <i class='bx bxs-dashboard text-xl'></i>
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]' }}">
                <i class='bx bxs-group text-xl'></i>
                Usuarios
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]' }}">
                <i class='bx bxs-category text-xl'></i>
                Categorías
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]' }}">
                <i class='bx bxs-t-shirt text-xl'></i>
                Productos
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : 'text-[#607D8B] hover:bg-[#F8FAF7] hover:text-[#2E7D32]' }}">
                <i class='bx bxs-shopping-bags text-xl'></i>
                Órdenes
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-[#E5E7EB] h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <button @click="sidebarOpen = true" class="md:hidden text-[#607D8B]">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            
            <div class="flex-1 flex items-center justify-end">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-[#607D8B] hover:text-[#2E7D32] hidden sm:block">Ir a la tienda</a>
                    
                    <div class="h-8 w-px bg-[#E5E7EB] mx-2"></div>
                    
                    <div class="flex items-center gap-3">
                        <img class="w-10 h-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}" alt="Admin">
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-medium text-[#263238]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[#607D8B]">Administrador</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F8FAF7] p-6 lg:p-8">
            @if (session('success'))
                <div class="bg-[#43A047]/10 border border-[#43A047]/20 text-[#2E7D32] px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                    <i class='bx bxs-check-circle text-xl'></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-[#E53935]/10 border border-[#E53935]/20 text-[#C62828] px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                    <i class='bx bxs-error-circle text-xl'></i>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Overlay -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/50 md:hidden" @click="sidebarOpen = false" style="display: none;"></div>

</body>
</html>
