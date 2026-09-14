@props(['disabled' => false, 'error' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full px-4 py-3 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm ' . ($error ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-400')]) !!}>{{ $slot }}</textarea>
