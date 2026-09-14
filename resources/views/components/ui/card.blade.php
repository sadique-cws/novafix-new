@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-gray-200 overflow-hidden']) }}>
  @if($title || isset($header))
    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50/50">
      @if(isset($header))
        {{ $header }}
      @else
        <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        @if($description)
          <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        @endif
      @endif
    </div>
  @endif
  
  <div class="p-4">
    {{ $slot }}
  </div>
  
  @if(isset($footer))
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
      {{ $footer }}
    </div>
  @endif
</div>
