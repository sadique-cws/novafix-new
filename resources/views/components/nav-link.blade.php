@props(['active'])

@php
$classes = ($active ?? false)
            ? 'p-1 border bg-[#1E40AF] text-[#F9FAFB] flex items-center justify-center font-medium rounded'
            : 'p-1 border bg-[#F9FAFB] text-[#111827] flex items-center justify-center font-medium rounded';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
