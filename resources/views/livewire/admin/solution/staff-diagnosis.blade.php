<div>
    <livewire:admin.components.navigation />
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
            <div class="flex flex-col md:flex-row md:justify-between md:items-center p-6 md:p-10 gap-6">
                <!-- Question Section -->
                <div class="flex-1 text-center md:text-center">
                    <p class="text-2xl font-medium text-gray-900 mb-6">
                        {{ $currentQuestion->question_text }}
                    </p>

                    <div class="flex justify-center md:justify-center space-x-4 mb-6">
                        <button wire:click="answerQuestion('yes')"
                            class="px-6 py-2 bg-green-600 text-white text-xl rounded-md font-medium hover:bg-green-700 transition-colors">
                            <i class="fa-regular fa-circle-check"></i>
                            Yes
                        </button>
                        <button wire:click="answerQuestion('no')"
                            class="px-6 py-2 bg-red-600 text-white text-xl rounded-md font-medium hover:bg-red-700 transition-colors">
                            <i class="fa-regular fa-circle-xmark"></i>
                            No
                        </button>
                    </div>

                    @if (\App\Models\Question::where('yes_question_id', $currentQuestion->id)->orWhere('no_question_id', $currentQuestion->id)->exists())
                        <button wire:click="previousQuestion"
                            class="text-[#111827] text-lg bg-gray-300 rounded py-1 px-3 font-medium transition-colors">
                            <i class="fa-solid text-[#111827] fa-arrow-left"></i>
                            Previous Question
                        </button>
                    @endif
                </div>
                @if ($currentQuestion->image_url || $currentQuestion->description)
                    <div class="flex flex-col items-center md:items-start gap-3 md:w-1/3 text-center md:text-left">
                        @if ($currentQuestion->image_url)
                            <div class="flex flex-col gap-1">
                                <p
                                    class=" text-gray-700
                                                                                                                                                                                                                                                                                                                                 font-medium">
                                    Related Image
                                    :-</p>
                                <img src="{{ $currentQuestion->image_url }}" class="h-32 w-64 object-fit rounded shadow"
                                    alt="Question Image">
                            </div>
                        @endif
                        @if ($currentQuestion->description)
                            <div class="flex flex-col gap-1">
                                <label for=""
                                    class="text-gray-700
                                                                                                                                                                                                                                                                                                                                 font-medium">Explanation
                                    :-</label>
                                <p class="text-gray-700 text-base leading-relaxed">
                                    {{ $currentQuestion->description }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>