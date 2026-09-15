@props([
  'variant' => 'primary', // primary, secondary, danger, outline, ghost
  'size' => 'md', // sm, md, lg
  'type' => 'button',
  'icon' => null,
  'iconPosition' => 'left' // left, right
])

@php
  // Base classes for all buttons
  $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed';
  
  // Variant classes
  $variantClasses = match($variant) {
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
    'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    'outline' => 'bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-blue-500',
    'ghost' => 'bg-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:ring-gray-500',
    default => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
  };
  
  // Size classes
  $sizeClasses = match($size) {
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
    default => 'px-4 py-2 text-sm',
  };
  
  // Icon spacing
  $iconClasses = match($size) {
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
    default => 'text-sm',
  };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $variantClasses $sizeClasses"]) }}>
  @if($icon && $iconPosition === 'left')
    <i class="{{ $icon }} {{ $iconClasses }} {{ $slot->isEmpty() ? '' : 'mr-2' }}"></i>
  @endif
  
  {{ $slot }}
  
  @if($icon && $iconPosition === 'right')
    <i class="{{ $icon }} {{ $iconClasses }} {{ $slot->isEmpty() ? '' : 'ml-2' }}"></i>
  @endif
</button>
