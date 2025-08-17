<div class="mx-auto bg-slate-100 rounded-lg">
    <div class="flex items-center justify-between p-3 bg-slate-300">
        <h3 class="text-lg font-semibold">Support Diagnosis</h3>

        <!-- Reset Button -->
        <button wire:click="resetSelection" class="font-semibold text-sm px-2 py-1 bg-red-500 rounded ">Reset</button>
    </div>
    <div class="p-3 grid grid-cols-4 gap-5">

        {{-- Device Selection --}}
        <div>
            <label class="block font-medium text-gray-700">Select Device:</label>
            <select wire:model="selectedDevice" wire:change="updateSelectedDevice"
                class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-400 {{$selectedDevice ? " bg-slate-200 cursor-not-allowed" : ''}}"
                {{ $selectedDevice ? 'disabled' : '' }}>
                <option value="">Choose Device</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- Brand Selection --}}
        @if($brands)
            <div>
                <label class="block font-medium text-gray-700">Select Brand:</label>
                <select wire:model="selectedBrand" wire:change="updateSelectedBrand"
                    class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-400 {{$selectedBrand ? " bg-slate-200 cursor-not-allowed" : ''}}"
                    {{ $selectedBrand ? 'disabled bg-slate-200' : '' }}>
                    <option value="">Choose Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        {{--Model selection--}}
        @if($models)
            <div>
                <label class="block font-medium text-gray-700">Select Model:</label>
                <select wire:model="selectedModel"
                wire:change="updateSelectedModel"
                    class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-400 {{$selectedModel ? " bg-slate-200 cursor-not-allowed" : ''}}"
                    {{ $selectedModel ? 'disabled bg-slate-200' : '' }}>
                    <option value="">Choose MOdel</option>
                    @foreach($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        {{--Problem Selection--}}
         @if($problems)
            <div>
                <label class="block font-medium text-gray-700">Select Device problem:</label>
                <select wire:model="selectedProblem"
                wire:change="updateSelectedProblem"
                    class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-400 {{$selectedProblem ? " bg-slate-200 cursor-not-allowed" : ''}}"
                    {{ $selectedProblem ? 'disabled bg-slate-200' : '' }}>
                    <option value="">Choose Device Problem</option>
                    @foreach($problems as $problem)
                        <option value="{{ $problem->id }}">{{ $problem->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
</div>