@props([
    'disabled' => false
])

<input
    {{ $disabled ? 'disabled' : '' }}

    {{ $attributes->merge([
        'class' => 'w-full rounded-xl border border-gray-300 px-4 py-3
                    focus:border-green-700
                    focus:ring-2
                    focus:ring-green-700
                    outline-none
                    transition'
    ]) }}>