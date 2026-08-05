@extends('layouts.rewear')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#F8FAF7] via-white to-[#F1F8E9]">

    {{-- Hero Banner --}}
    <div class="relative bg-gradient-to-r from-[#1B5E20] to-[#2E7D32] overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl backdrop-blur-sm mb-6">
                @yield('page-icon', '<i class="bx bx-file text-3xl text-white"></i>')
            </div>
            <h1 class="text-4xl font-outfit font-bold text-white mb-4">{{ $title }}</h1>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">@yield('page-subtitle')</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-sm border border-[#E5E7EB] p-8 md:p-12">
            @yield('page-content')
        </div>

        {{-- Back link --}}
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[#607D8B] hover:text-[#2E7D32] transition-colors font-medium">
                <i class="bx bx-arrow-back"></i>
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection
