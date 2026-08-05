<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'username'    => ['nullable', 'string', 'max:60', 'unique:users,username,' . auth()->id()],
            'email'       => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'bio'         => ['nullable', 'string', 'max:500'],
            'avatar'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'first_name'  => ['nullable', 'string', 'max:100'],
            'last_name'   => ['nullable', 'string', 'max:150'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'birth_date'  => ['nullable', 'date', 'before:today'],
            'gender'      => ['nullable', 'in:Male,Female,Other'],
            'country'     => ['nullable', 'string', 'max:100'],
            'state'       => ['nullable', 'string', 'max:100'],
            'city'        => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'El nombre es obligatorio.',
            'email.required'   => 'El correo electrónico es obligatorio.',
            'email.unique'     => 'Este correo ya está en uso.',
            'username.unique'  => 'Este nombre de usuario ya está en uso.',
            'avatar.image'     => 'El archivo debe ser una imagen.',
            'avatar.max'       => 'La foto no puede superar los 2MB.',
        ];
    }
}
