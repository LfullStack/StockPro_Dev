@props([
    'id' => '',
    'color' => 'blue', // blue, gray, red, green, yellow, indigo, purple, pink
])

@php
    $baseClasses = 'inline-block px-4 py-2 text-white rounded text-sm transition-colors duration-200 font-semibold';

    $colorClasses = [
        'blue'    => 'bg-blue-600 hover:bg-blue-700',
        'gray'    => 'bg-gray-600 hover:bg-gray-700',
        'red'     => 'bg-red-600 hover:bg-red-700',
        'green'   => 'bg-green-600 hover:bg-green-700',
        'yellow'  => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        'indigo'  => 'bg-indigo-600 hover:bg-indigo-700',
        'purple'  => 'bg-purple-600 hover:bg-purple-700',
        'pink'    => 'bg-pink-500 hover:bg-pink-600',
    ];

    $class = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<button id="{{ $id }}" {{ $attributes->merge(['class' => "$baseClasses $class"]) }}>
    {{ $slot }}
</button>
