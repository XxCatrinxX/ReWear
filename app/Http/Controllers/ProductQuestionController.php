<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductQuestion;
use Illuminate\Http\Request;

class ProductQuestionController extends Controller
{
    /**
     * Guarda una pregunta hecha por el comprador sobre un producto.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'question' => ['required', 'string', 'max:500'],
        ], [
            'question.required' => 'Escribe tu pregunta antes de enviar.',
            'question.max'      => 'La pregunta no puede exceder los 500 caracteres.',
        ]);

        ProductQuestion::create([
            'product_id' => $product->id,
            'user_id'    => $request->user()->id,
            'question'   => $request->input('question'),
        ]);

        return back()->with('success', '¡Tu pregunta ha sido enviada al vendedor!');
    }

    /**
     * Permite al vendedor responder a una pregunta realizada.
     */
    public function answer(Request $request, ProductQuestion $question)
    {
        // Verificar que el usuario sea el dueño del producto
        if ($request->user()->id !== $question->product->user_id) {
            abort(403, 'No tienes permiso para responder a esta pregunta.');
        }

        $request->validate([
            'answer' => ['required', 'string', 'max:500'],
        ], [
            'answer.required' => 'Escribe una respuesta antes de enviar.',
        ]);

        $question->update([
            'answer'      => $request->input('answer'),
            'answered_at' => now(),
        ]);

        return back()->with('success', '¡Respuesta publicada con éxito!');
    }
}
