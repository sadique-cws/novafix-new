@props([
  'color' => 'gray', // gray, red, yellow, green, blue, indigo, purple, pink
  'size' => 'md', // sm, md, lg
  'rounded' => 'full' // full, md
])

@php
  $baseClasses = 'inline-flex items-center justify-center font-medium';
  
  $sizeClasses = match($size) {
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-0.5 text-sm',
    'lg' => 'px-3 py-1 text-base',
    default => 'px-2.5 py-0.5 text-sm',
  };
  
  $roundedClass = match($rounded) {
    'full' => 'rounded-full',
    'md' => 'rounded-md',
    default => 'rounded-full',
  };
  
  $colorClasses = match($color) {
    'gray' => 'bg-gray-100 text-gray-800 border border-gray-200',
    'red' => 'bg-red-50 text-red-700 border border-red-200',
    'yellow' => 'bg-yellow-50 text-yellow-800 border border-yellow-200',
    'green' => 'bg-green-50 text-green-700 border border-green-200',
    'blue' => 'bg-blue-50 text-blue-700 border border-blue-200',
    'indigo' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
    'purple' => 'bg-purple-50 text-purple-700 border border-purple-200',
    'pink' => 'bg-pink-50 text-pink-700 border border-pink-200',
    default => 'bg-gray-100 text-gray-800 border border-gray-200',
  };
@endphp

<span {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $roundedClass $colorClasses"]) }}>
  {{ $slot }}
</span>
