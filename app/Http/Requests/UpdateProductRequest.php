<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        $product = $this->route('product');
        return auth()->check() && auth()->id() === $product->user_id;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:20'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand'       => ['nullable', 'string', 'max:100'],
            'size'        => ['nullable', 'string', 'max:20'],
            'color'       => ['nullable', 'string', 'max:50'],
            'condition'   => ['required', 'in:' . implode(',', array_keys(Product::$conditions))],
            'price'       => ['required', 'numeric', 'min:1', 'max:999999'],
            'stock'       => ['required', 'integer', 'min:0', 'max:999'],
            'is_active'   => ['boolean'],
            'images'      => ['nullable', 'array', 'max:8'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:product_images,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'El título es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'category_id.required' => 'Selecciona una categoría.',
            'condition.required'   => 'El estado de la prenda es obligatorio.',
            'price.required'       => 'El precio es obligatorio.',
        ];
    }
}
