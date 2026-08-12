@extends('layouts.rewear')
@section('title', 'Mis Notificaciones')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-outfit text-3xl font-bold text-[#263238]">Notificaciones</h1>
            <p class="text-[#607D8B] mt-1">Mantente al tanto de tus ventas, compras, envíos y preguntas.</p>
        </div>

        @if(auth()->user()->unreadNotificationsCount() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-white border border-[#E5E7EB] hover:bg-[#F8FAF7] text-[#2E7D32] font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-1.5">
                    <i class='bx bx-check-double text-base'></i> Marcar todas como leídas
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 flex items-center gap-2 text-sm">
            <i class='bx bx-check-circle text-lg'></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-[#E5E7EB] shadow-sm overflow-hidden divide-y divide-[#E5E7EB]">
        @forelse($notifications as $notif)
            @php
                $style = \App\Models\Notification::$typeIcons[$notif->type] ?? ['icon' => 'bx-bell', 'color' => 'bg-gray-100 text-gray-700'];
                $isUnread = is_null($notif->read_at);
            @endphp
            <div class="p-5 flex items-start gap-4 transition hover:bg-[#F8FAF7] {{ $isUnread ? 'bg-emerald-50/20' : '' }}">
                <div class="w-10 h-10 rounded-2xl {{ $style['color'] }} flex items-center justify-center text-xl shrink-0">
                    <i class='bx {{ $style['icon'] }}'></i>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <h4 class="font-bold text-sm text-[#263238] flex items-center gap-2">
                            {{ $notif->title }}
                            @if($isUnread)
                                <span class="w-2 h-2 rounded-full bg-[#2E7D32] inline-block"></span>
                            @endif
                        </h4>
                        <span class="text-[11px] text-[#607D8B] shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-[#607D8B] leading-relaxed mb-3">{{ $notif->message }}</p>

                    @if($notif->link)
                        <form action="{{ route('notifications.read', $notif) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 text-xs font-bold text-[#2E7D32] hover:underline">
                                Ver detalle <i class='bx bx-right-arrow-alt'></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-16 text-center text-[#607D8B]">
                <i class='bx bx-bell-off text-5xl mb-3 block text-gray-300'></i>
                <p class="font-semibold text-base text-[#263238]">No tienes notificaciones por el momento</p>
                <p class="text-xs mt-1">Aquí aparecerán los avisos sobre tus ventas, compras y preguntas.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection
