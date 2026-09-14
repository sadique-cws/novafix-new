@props(['disabled' => false, 'error' => false, 'icon' => null])

<div class="relative">
  @if($icon)
  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
    <i class="{{ $icon }} text-gray-400"></i>
  </div>
  @endif
  
  <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full py-2 rounded-md border transition-colors focus:outline-none focus:border-gray-900 focus:ring-0 sm:text-sm bg-white ' . ($icon ? 'pl-10 pr-3 ' : 'px-3 ') . ($error ? 'border-red-300 text-red-900 placeholder-red-300' : 'border-gray-300 text-gray-900 placeholder-gray-400')]) !!}>
  
  @if($error)
  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
    <i class="fas fa-exclamation-circle text-red-500"></i>
  </div>
  @endif
</div>
