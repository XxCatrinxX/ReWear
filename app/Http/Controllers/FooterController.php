<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Show a static footer page.
     *
     * @param string $page The page slug
     * @return \Illuminate\View\View
     */
    public function show($page)
    {
        $allowed = [
            'terms'        => 'Términos y Condiciones',
            'privacy'      => 'Política de Privacidad',
            'how-it-works' => '¿Cómo Funciona ReWear?',
            'how-to-sell'  => '¿Cómo vender en ReWear?',
            'seller-guide' => 'Guía del Vendedor',
            'fees'         => 'Comisiones y Tarifas',
            'returns'      => 'Política de Devoluciones',
            'faq'          => 'Preguntas Frecuentes',
            'shipping'     => 'Envíos y Entregas',
            'contact'      => 'Contacto',
        ];

        if (!array_key_exists($page, $allowed)) {
            abort(404);
        }

        $title = $allowed[$page];

        return view('footer.' . $page, compact('title'));
    }

    /**
     * Handle the contact form submission.
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:200',
            'subject' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        // In production, send an email here using Mail::to(...)
        // For now, we just redirect back with a success message.

        return redirect()
            ->route('footer.show', ['page' => 'contact'])
            ->with('contact_success', true);
    }
}
