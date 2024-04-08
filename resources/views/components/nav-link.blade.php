@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-beige-accent text-sm font-medium leading-5 text-beige-accent focus:outline-none focus:border-beige-accent transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-700 hover:text-beige-accent-hover hover:border-beige-accent-hover focus:outline-none focus:text-gray-700 focus:border-beige-accent-hover transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
