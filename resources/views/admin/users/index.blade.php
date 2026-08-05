@extends('layouts.admin')
@section('title', 'Gestión de Usuarios')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    <div>
        <h1 class="font-outfit text-3xl font-bold text-[#263238] mb-2">Usuarios</h1>
        <p class="text-[#607D8B]">Administra los usuarios registrados en la plataforma.</p>
    </div>
    
    <div class="w-full md:w-auto">
        <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
            <input type="text" name="search" placeholder="Buscar usuario..." value="{{ request('search') }}"
                class="w-full md:w-64 bg-white border border-[#E5E7EB] rounded-full py-2 pl-10 pr-4 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20">
            <i class='bx bx-search absolute left-3.5 top-1/2 -translate-y-1/2 text-[#607D8B] text-lg'></i>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-[#E5E7EB] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs text-[#607D8B] uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Usuario</th>
                    <th class="px-6 py-4 font-medium">Rol</th>
                    <th class="px-6 py-4 font-medium">Registro</th>
                    <th class="px-6 py-4 font-medium text-center">Estado</th>
                    <th class="px-6 py-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E7EB]">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full border border-[#E5E7EB]">
                                <div>
                                    <p class="font-medium text-[#263238] text-sm">{{ $user->name }}
                                        @if($user->is_admin)
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#263238] text-white uppercase tracking-wider" title="Administrador">Admin</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-[#607D8B]">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_seller)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#D4A373]/20 text-[#b88c63]">Vendedor</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Comprador</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-[#607D8B]">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->status)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Cambiar Estado -->
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-2 rounded-lg transition-colors {{ $user->status ? 'text-red-500 hover:bg-red-50' : 'text-green-500 hover:bg-green-50' }}" title="{{ $user->status ? 'Desactivar' : 'Activar' }}">
                                            <i class='bx {{ $user->status ? 'bx-block' : 'bx-check-circle' }} text-xl'></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="p-2 text-gray-300" title="No puedes cambiar tu propio estado"><i class='bx bx-block text-xl'></i></span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $users->links() }}
</div>
@endsection
