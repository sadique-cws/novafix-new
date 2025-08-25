<div>
    <div class="mx-auto mt-5 bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header Section -->
        <div class="flex items-center justify-between px-4 py-3 bg-[#1E40AF] text-[#F9FAFB]">
            <h3 class="text-xl font-medium">Support Diagnosis</h3>
            <button wire:click="resetSelection"
                class="px-3 py-1 bg-white text-blue-600 rounded-md text-sm font-medium hover:bg-blue-50 transition-colors">
                Reset Selection
            </button>
        </div>

        <!-- Selection Grid -->
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 border-b">
            <!-- Device Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Device</label>
                <select wire:model="selectedDevice" wire:change="updateSelectedDevice"
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{$selectedDevice ? 'bg-gray-100 cursor-not-allowed' : ''}}"
                    {{ $selectedDevice ? 'disabled' : '' }}>
                    <option value="">Choose Device</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Brand Selection -->
            @if($brands)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Brand</label>
                    <select wire:model="selectedBrand" wire:change="updateSelectedBrand"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{$selectedBrand ? 'bg-gray-100 cursor-not-allowed' : ''}}"
                        {{ $selectedBrand ? 'disabled' : '' }}>
                        <option value="">Choose Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Model Selection -->
            @if($models)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Model</label>
                    <select wire:model="selectedModel" wire:change="updateSelectedModel"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{$selectedModel ? 'bg-gray-100 cursor-not-allowed' : ''}}"
                        {{ $selectedModel ? 'disabled' : '' }}>
                        <option value="">Choose Model</option>
                        @foreach($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Problem Selection -->
            @if($problems)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Problem</label>
                    <select wire:model="selectedProblem" wire:change="updateSelectedProblem"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{$selectedProblem ? 'bg-gray-100 cursor-not-allowed' : ''}}"
                        {{ $selectedProblem ? 'disabled' : '' }}>
                        <option value="">Choose Problem</option>
                        @foreach($problems as $problem)
                            <option value="{{ $problem->id }}">{{ $problem->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
        @if($currentQuestion)
            <div class="mt-4 bg-white p-4 rounded border max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Text Content --}}
                    <div class="md:w-1/2 p-2">
                        <p class="text-2xl text-gray-800 mb-3">
                            {{ $currentQuestion->question_text }}
                        </p>

                        @if ($currentQuestion->description)
                            <p class="text-lg text-gray-600 mb-4">
                                {{ $currentQuestion->description }}
                            </p>
                        @endif

                        <div class="flex space-x-4 mt-4">
                            <button class="text-xl bg-blue-500 text-white px-4 py-2 rounded"
                                wire:click="answerQuestion('yes')">
                                Yes
                            </button>
                            <button class="text-xl bg-red-500 text-white px-4 py-2 rounded"
                                wire:click="answerQuestion('no')">
                                No
                            </button>
                        </div>
                    </div>

                    {{-- Image --}}
                    @if ($currentQuestion->image_url)
                        <div class="md:w-1/2 p-2 flex flex-col items-center justify-center">
                            <p class="text-gray-600 mb-2">Have you seen like this?</p>
                            <img src="{{ $currentQuestion->image_url }}" class="max-h-64 w-auto rounded border"
                                alt="Related image">
                        </div>
                    @endif
                </div>
                @if (
                        \App\Models\Question::where('yes_question_id', $currentQuestion->id)
                            ->orWhere('no_question_id', $currentQuestion->id)->exists()
                    )
                    <button wire:click="previousQuestion"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                        ← Previous Question
                    </button>
                @endif
            </div>
       @endif

       @if(!$selectedDevice && !$selectedBrand && !$selectedModel && !$selectedProblem)
    </div>
</div>