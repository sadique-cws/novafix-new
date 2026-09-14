@props(['disabled' => false, 'error' => false, 'icon' => null, 'searchable' => false, 'placeholder' => 'Select an option'])

@if($searchable)
    @once
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <style>
            .ts-wrapper .ts-control {
                border-radius: 0.375rem;
                border-color: #d1d5db;
                padding: 0.625rem 1rem;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                min-height: 44px;
                display: flex;
                align-items: center;
            }

            .ts-wrapper.focus .ts-control {
                border-color: #1E40AF;
                box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2);
            }

            .ts-dropdown {
                border-radius: 0.375rem;
                border-color: #d1d5db;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                padding: 0.25rem 0;
            }

            .ts-dropdown .active {
                background-color: #f3f4f6;
                color: #111827;
            }

            .ts-dropdown .option {
                padding: 0.5rem 1rem;
                cursor: pointer;
            }

            .ts-dropdown .option:hover {
                background-color: #f3f4f6;
            }
        </style>
    @endonce

    <div wire:ignore class="relative" x-data="{
                ts: null,
                init() {
                    this.ts = new TomSelect(this.$refs.select, {
                        create: false,
                        placeholder: '{{ $placeholder }}',
                        onChange: (val) => {
                            this.$refs.select.value = val;
                            this.$refs.select.dispatchEvent(new Event('input', { bubbles: true }));
                            this.$refs.select.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    });

                    // If Livewire resets the DOM or updates the value from outside
                    if (this.$refs.select.value) {
                        this.ts.setValue(this.$refs.select.value, true);
                    }
                }
             }">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif

        <select x-ref="select" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'hidden ' . ($icon ? 'pl-10' : '')]) !!}>
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

        <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full py-2.5 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm appearance-none bg-white ' . ($icon ? 'pl-10 pr-10 ' : 'px-4 pr-10 ') . ($error ? 'border-red-300 text-red-900 focus:ring-red-500' : 'border-gray-300 text-gray-900')]) !!}>
            {{ $slot }}
        </select>

        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
        </div>
    </div>
@endif