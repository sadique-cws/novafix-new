@props(['disabled' => false, 'error' => false, 'icon' => null])

<div class="relative">
    @if($icon)
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <i class="{{ $icon }} text-gray-400"></i>
    </div>
    @endif
    
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm ' . ($icon ? 'pl-10 pr-3 ' : 'px-4 ') . ($error ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500' : 'border-gray-300 text-gray-900 placeholder-gray-400')]) !!}>
    
    @if($error)
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
        <i class="fas fa-exclamation-circle text-red-500"></i>
    </div>
    @endif
</div>
