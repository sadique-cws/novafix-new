@props(['active'])

@php
$classes = ($active ?? false)
            ? 'p-1 border bg-gray-400 flex items-center justify-center font-medium rounded'
            : 'p-1 border bg-gray-200 flex items-center justify-center font-medium rounded';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
