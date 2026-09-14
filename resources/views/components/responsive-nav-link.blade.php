@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg ps-4 pe-4 py-2 text-start text-base font-semibold text-blue-700 bg-blue-50 focus:outline-none focus:text-blue-700 focus:bg-blue-100 transition duration-150 ease-in-out'
            : 'block w-full rounded-lg ps-4 pe-4 py-2 text-start text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>