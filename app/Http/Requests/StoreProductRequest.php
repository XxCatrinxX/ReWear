<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isSeller();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:20'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand'       => ['nullable', 'string', 'max:100'],
            'size'        => ['nullable', 'string', 'max:20'],
            'color'       => ['required', 'string', Rule::in(array_keys(Product::$colors))],
            'condition'   => ['required', 'in:' . implode(',', array_keys(Product::$conditions))],
            'price'       => ['required', 'numeric', 'min:1', 'max:999999'],
            'stock'       => ['required', 'integer', 'min:1', 'max:999'],
            'images'      => ['nullable', 'array', 'max:8'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'El título es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'description.min'      => 'La descripción debe tener al menos 20 caracteres.',
            'category_id.required' => 'Selecciona una categoría.',
            'category_id.exists'   => 'La categoría seleccionada no existe.',
            'condition.required'   => 'El estado de la prenda es obligatorio.',
            'price.required'       => 'El precio es obligatorio.',
            'price.min'            => 'El precio mínimo es $1.',
            'images.*.image'       => 'Cada archivo debe ser una imagen.',
            'images.*.max'         => 'Cada imagen no puede superar los 5MB.',
        ];
    }
}
