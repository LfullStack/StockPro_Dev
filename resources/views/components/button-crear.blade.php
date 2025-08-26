@props([
    'href' => '#',
    'color' => 'red',
    'target' => null,
])

@php
    $baseClasses = 'inline-block px-4 py-2 text-white rounded text-sm transition-colors duration-200 font-semibold';

    $colorClasses = [
        'blue'    => 'bg-blue-600 hover:bg-blue-700 text-white',
        'green'   => 'bg-green-600 hover:bg-green-700 text-white',
        'red'     => 'bg-red-600 hover:bg-red-700 text-white',
        'gray'    => 'bg-gray-600 hover:bg-gray-700 text-white',
        'yellow'  => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        'purple'  => 'bg-purple-600 hover:bg-purple-700 text-white',
        'pink'    => 'bg-pink-500 hover:bg-pink-600 text-white',
        'white'   => 'bg-white hover:bg-gray-100 text-black border border-gray-300',
    ];

    $class = $colorClasses[$color] ?? $colorClasses['red'];
@endphp

<a href="{{ $href }}"
    {{ $attributes->merge(['class' => "$baseClasses $class"]) }}
    @if ($target) target="{{ $target }}" @endif>
        {{ $slot }}
</a>
