<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'label'            => ['required', 'string', 'max:50'],
            'recipient_name'   => ['required', 'string', 'max:150'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'street'           => ['required', 'string', 'max:200'],
            'exterior_number'  => ['nullable', 'string', 'max:20'],
            'interior_number'  => ['nullable', 'string', 'max:20'],
            'neighborhood'     => ['nullable', 'string', 'max:100'],
            'city'             => ['required', 'string', 'max:100'],
            'state'            => ['required', 'string', 'max:100'],
            'postal_code'      => ['required', 'string', 'max:10'],
            'country'          => ['required', 'string', 'max:100'],
            'references'       => ['nullable', 'string', 'max:300'],
            'is_default'       => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'recipient_name.required' => 'El nombre del destinatario es obligatorio.',
            'street.required'         => 'La calle es obligatoria.',
            'city.required'           => 'La ciudad es obligatoria.',
            'state.required'          => 'El estado es obligatorio.',
            'postal_code.required'    => 'El código postal es obligatorio.',
        ];
    }
}
