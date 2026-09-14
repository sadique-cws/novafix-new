@props(['disabled' => false, 'error' => false, 'icon' => null, 'searchable' => false, 'placeholder' => 'Select an option'])

@if($searchable)
  @once
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
      .ts-wrapper .ts-control {
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        padding: 0.5rem 2.5rem 0.5rem 0.75rem;
        box-shadow: none;
        min-height: 38px;
        background-color: #ffffff;
        font-size: 0.875rem;
        line-height: 1.25rem;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        cursor: pointer;
      }
      
      .ts-wrapper.has-icon .ts-control {
        padding-left: 2.5rem;
      }

      .ts-wrapper.focus .ts-control {
        border-color: #111827; 
        box-shadow: none;
      }

      .ts-dropdown {
        border-radius: 0.375rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        padding: 0;
        margin-top: 4px;
      }
      
      .ts-dropdown .dropdown-input-wrap {
        padding: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
      }

      .ts-dropdown .dropdown-input {
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        width: 100%;
        outline: none;
      }
      
      .ts-dropdown .dropdown-input:focus {
        border-color: #111827;
      }

      .ts-dropdown .active {
        background-color: #f3f4f6;
        color: #111827;
      }

      .ts-dropdown .option {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        font-size: 0.875rem;
      }

      .ts-dropdown .option:hover {
        background-color: #f3f4f6;
      }
    </style>
  @endonce

  <div wire:ignore class="relative {{ $icon ? 'has-icon' : '' }}" x-data="{
        ts: null,
        init() {
          const initTomSelect = () => {
            if (typeof TomSelect === 'undefined') {
              setTimeout(initTomSelect, 100);
              return;
            }
            this.ts = new TomSelect(this.$refs.select, {
              create: false,
              plugins: ['dropdown_input'],
              placeholder: '{{ $placeholder }}',
              onChange: (val) => {
                this.$refs.select.value = val;
                this.$refs.select.dispatchEvent(new Event('input', { bubbles: true }));
                this.$refs.select.dispatchEvent(new Event('change', { bubbles: true }));
              }
            });

            if (this.$refs.select.value) {
              this.ts.setValue(this.$refs.select.value, true);
            }
          };
          
          initTomSelect();
        }
       }">
    @if($icon)
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
        <i class="{{ $icon }} text-gray-400"></i>
      </div>
    @endif

    <select x-ref="select" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full']) !!}>
      {{ $slot }}
    </select>
  </div>
@else
  <!-- Standard select -->
  <div class="relative">
    @if($icon)
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <i class="{{ $icon }} text-gray-400"></i>
      </div>
    @endif

    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full py-2 rounded-md border transition-colors focus:outline-none focus:border-gray-900 focus:ring-0 sm:text-sm appearance-none bg-white ' . ($icon ? 'pl-10 pr-10 ' : 'px-3 pr-10 ') . ($error ? 'border-red-300 text-red-900' : 'border-gray-300 text-gray-900')]) !!}>
      {{ $slot }}
    </select>

    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
      <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
    </div>
  </div>
@endif