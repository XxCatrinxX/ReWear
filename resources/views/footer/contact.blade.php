@extends('footer._layout')

@section('page-icon')<i class="bx bx-envelope text-3xl text-white"></i>@endsection
@section('page-subtitle', 'Estamos aquí para ayudarte. Contáctanos y te responderemos pronto.')

@section('page-content')
<div class="text-[#455A64] leading-relaxed">

    <div class="grid md:grid-cols-2 gap-12">

        {{-- Contact info --}}
        <div>
            <h2 class="text-xl font-outfit font-bold text-[#263238] mb-6">Medios de Contacto</h2>
            <div class="space-y-5">
                <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-envelope text-white text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-outfit font-semibold text-[#263238] mb-1">Correo Electrónico</h4>
                        <a href="mailto:soporte@rewear.mx" class="text-[#2E7D32] hover:underline text-sm font-medium">soporte@rewear.mx</a>
                        <p class="text-xs text-[#90A4AE] mt-1">Respondemos en menos de 24 horas hábiles.</p>
                    </div>
                </div>
                <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bx bxl-whatsapp text-white text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-outfit font-semibold text-[#263238] mb-1">WhatsApp</h4>
                        <p class="text-[#2E7D32] text-sm font-medium">+52 55 1234 5678</p>
                        <p class="text-xs text-[#90A4AE] mt-1">Lunes a Viernes, 9:00 – 18:00 hrs.</p>
                    </div>
                </div>
                <div class="flex gap-4 p-5 bg-[#F8FAF7] rounded-2xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#2E7D32] to-[#43A047] rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bx bxl-instagram text-white text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-outfit font-semibold text-[#263238] mb-1">Redes Sociales</h4>
                        <p class="text-[#2E7D32] text-sm font-medium">@rewear.mx</p>
                        <p class="text-xs text-[#90A4AE] mt-1">Instagram, TikTok y Facebook.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 p-5 bg-[#E8F5E9] rounded-2xl border border-[#A5D6A7]">
                <h4 class="font-outfit font-semibold text-[#263238] mb-2 flex items-center gap-2">
                    <i class="bx bx-time text-[#2E7D32]"></i> Horario de Atención
                </h4>
                <div class="text-sm space-y-1">
                    <div class="flex justify-between"><span>Lunes – Viernes</span><strong>9:00 – 18:00 hrs</strong></div>
                    <div class="flex justify-between"><span>Sábado</span><strong>10:00 – 14:00 hrs</strong></div>
                    <div class="flex justify-between text-[#90A4AE]"><span>Domingo</span><strong>Cerrado</strong></div>
                </div>
            </div>
        </div>

        {{-- Contact form --}}
        <div>
            <h2 class="text-xl font-outfit font-bold text-[#263238] mb-6">Envíanos un Mensaje</h2>

            @if(session('contact_success'))
                <div class="bg-[#E8F5E9] border border-[#A5D6A7] rounded-2xl p-4 mb-6 flex items-center gap-3">
                    <i class="bx bxs-check-circle text-[#2E7D32] text-xl"></i>
                    <p class="text-sm text-[#2E7D32] font-medium">¡Mensaje enviado! Te responderemos pronto.</p>
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1.5">Tu nombre</label>
                    <input type="text" name="name" required value="{{ old('name', auth()->user()->name ?? '') }}"
                        class="w-full border border-[#E5E7EB] rounded-xl px-4 py-3 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 outline-none transition-all"
                        placeholder="Nombre completo">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1.5">Correo electrónico</label>
                    <input type="email" name="email" required value="{{ old('email', auth()->user()->email ?? '') }}"
                        class="w-full border border-[#E5E7EB] rounded-xl px-4 py-3 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 outline-none transition-all"
                        placeholder="correo@ejemplo.com">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1.5">Asunto</label>
                    <select name="subject" class="w-full border border-[#E5E7EB] rounded-xl px-4 py-3 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 outline-none transition-all bg-white">
                        <option value="">Selecciona un tema</option>
                        <option value="compra">Problema con una compra</option>
                        <option value="venta">Problema con una venta</option>
                        <option value="cuenta">Problema con mi cuenta</option>
                        <option value="envio">Problema con un envío</option>
                        <option value="pago">Problema con un pago o retiro</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#263238] mb-1.5">Mensaje</label>
                    <textarea name="message" required rows="5"
                        class="w-full border border-[#E5E7EB] rounded-xl px-4 py-3 text-sm focus:border-[#2E7D32] focus:ring focus:ring-[#2E7D32]/20 outline-none transition-all resize-none"
                        placeholder="Describe tu situación detalladamente...">{{ old('message') }}</textarea>
                    @error('message')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#2E7D32] to-[#43A047] text-white font-outfit font-semibold py-3.5 rounded-xl hover:shadow-lg hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                    <i class="bx bx-send"></i> Enviar Mensaje
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
