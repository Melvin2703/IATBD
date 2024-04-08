@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-beige-accent text-start text-base font-medium text-beige-accent bg-turquoise-main focus:outline-none focus:text-beige-accent focus:bg-turquoise-main focus:border-turquoise-main transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-700 hover:text-gray-700 hover:bg-turquoise-main hover:border-turquoise-main focus:outline-none focus:text-gray-700 focus:bg-turquoise-main focus:border-beige-accent transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
