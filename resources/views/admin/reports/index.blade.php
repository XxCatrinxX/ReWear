@extends('layouts.rewear')
@section('title', 'Reportes de Publicaciones')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238]">Reportes de publicaciones</h1>
            <p class="text-[#607D8B] mt-1">Revisa los reportes enviados por los usuarios.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-sm text-[#607D8B] hover:text-[#2E7D32] transition">
            <i class='bx bx-arrow-back'></i> Volver al panel
        </a>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2">
            <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 flex items-center gap-2">
            <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
        </div>
    @endif

    <!-- Contadores por estado -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <a href="{{ route('admin.reports.index') }}" class="bg-white rounded-2xl p-4 border border-[#E5E7EB] text-center hover:border-[#2E7D32] transition {{ !request('status') ? 'border-[#2E7D32] ring-1 ring-[#2E7D32]' : '' }}">
            <p class="text-2xl font-bold text-[#263238]">{{ $counts['pendiente'] + $counts['revisado'] + $counts['desestimado'] }}</p>
            <p class="text-sm text-[#607D8B]">Todos</p>
        </a>
        <a href="{{ route('admin.reports.index', ['status' => 'pendiente']) }}" class="bg-white rounded-2xl p-4 border border-[#E5E7EB] text-center hover:border-amber-400 transition {{ request('status') === 'pendiente' ? 'border-amber-400 ring-1 ring-amber-400' : '' }}">
            <p class="text-2xl font-bold text-amber-600">{{ $counts['pendiente'] }}</p>
            <p class="text-sm text-[#607D8B]">Pendientes</p>
        </a>
        <a href="{{ route('admin.reports.index', ['status' => 'revisado']) }}" class="bg-white rounded-2xl p-4 border border-[#E5E7EB] text-center hover:border-green-400 transition {{ request('status') === 'revisado' ? 'border-green-400 ring-1 ring-green-400' : '' }}">
            <p class="text-2xl font-bold text-green-600">{{ $counts['revisado'] }}</p>
            <p class="text-sm text-[#607D8B]">Revisados</p>
        </a>
    </div>

    <!-- Tabla de reportes -->
    <div class="bg-white rounded-3xl border border-[#E5E7EB] overflow-hidden shadow-sm">
        @if($reports->isEmpty())
            <div class="py-16 text-center text-[#607D8B]">
                <i class='bx bx-check-shield text-5xl mb-3 block text-green-400'></i>
                <p class="font-semibold">No hay reportes con este filtro.</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F8FAF7] border-b border-[#E5E7EB]">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-[#263238]">Publicación</th>
                        <th class="text-left px-6 py-4 font-semibold text-[#263238]">Motivo</th>
                        <th class="text-left px-6 py-4 font-semibold text-[#263238]">Reportado por</th>
                        <th class="text-left px-6 py-4 font-semibold text-[#263238]">Estado</th>
                        <th class="text-left px-6 py-4 font-semibold text-[#263238]">Fecha</th>
                        <th class="text-right px-6 py-4 font-semibold text-[#263238]">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E7EB]">
                    @foreach($reports as $report)
                    <tr class="hover:bg-[#F8FAF7] transition">
                        <td class="px-6 py-4">
                            @if($report->product)
                                <a href="{{ route('products.show', $report->product) }}" target="_blank"
                                   class="font-medium text-[#263238] hover:text-[#2E7D32] transition line-clamp-1 max-w-[200px] block">
                                    {{ $report->product->title }}
                                </a>
                                <span class="text-xs text-[#607D8B]">por {{ $report->product->user?->name ?? '—' }}</span>
                            @else
                                <span class="text-[#607D8B] italic text-xs">Publicación eliminada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-[#263238]">{{ $report->reason }}</p>
                            @if($report->details)
                                <p class="text-xs text-[#607D8B] mt-0.5 max-w-[200px] line-clamp-2">{{ $report->details }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[#263238]">{{ $report->user?->name ?? '—' }}</span>
                            <br><span class="text-xs text-[#607D8B]">{{ $report->user?->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badge = match($report->status) {
                                    'pendiente'   => 'bg-amber-100 text-amber-700',
                                    'revisado'    => 'bg-green-100 text-green-700',
                                    'desestimado' => 'bg-gray-100 text-gray-600',
                                    default       => 'bg-gray-100 text-gray-600',
                                };
                                $label = match($report->status) {
                                    'pendiente'   => 'Pendiente',
                                    'revisado'    => 'Revisado',
                                    'desestimado' => 'Desestimado',
                                    default       => $report->status,
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[#607D8B] text-xs">
                            {{ $report->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="flex items-center justify-end gap-2">
                                @csrf @method('PATCH')
                                <!-- Marcar como desestimado -->
                                <button type="submit" name="status" value="desestimado"
                                    onclick="this.form.querySelector('[name=delete_product]').value='0'"
                                    class="px-3 py-1.5 text-xs rounded-xl border border-[#E5E7EB] text-[#607D8B] hover:bg-gray-50 transition"
                                    title="Desestimar reporte">
                                    Ignorar
                                </button>
                                @if($report->product)
                                <!-- Marcar revisado sin eliminar -->
                                <button type="submit" name="status" value="revisado"
                                    onclick="this.form.querySelector('[name=delete_product]').value='0'"
                                    class="px-3 py-1.5 text-xs rounded-xl border border-green-300 text-green-700 hover:bg-green-50 transition"
                                    title="Marcar como revisado">
                                    Revisado
                                </button>
                                <!-- Eliminar publicación -->
                                <button type="submit" name="status" value="revisado"
                                    onclick="if(!confirm('¿Eliminar esta publicación? Esta acción no se puede deshacer.')) return false; this.form.querySelector('[name=delete_product]').value='1'"
                                    class="px-3 py-1.5 text-xs rounded-xl bg-red-500 text-white hover:bg-red-600 transition"
                                    title="Eliminar publicación">
                                    <i class='bx bx-trash'></i> Eliminar
                                </button>
                                @endif
                                <input type="hidden" name="delete_product" value="0">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-[#E5E7EB]">
                {{ $reports->links() }}
            </div>
        @endif
        @endif
    </div>
</div>
@endsection
