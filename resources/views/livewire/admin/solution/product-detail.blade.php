<div class="mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header Section -->
    <div class="flex items-center justify-between p-4 bg-blue-600 text-white">
        <h3 class="text-xl font-bold">Support Diagnosis</h3>
        <button wire:click="resetSelection" class="px-3 py-1 bg-white text-blue-600 rounded-md text-sm font-medium hover:bg-blue-50 transition-colors">
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

    <!-- Question Section -->
    @if ($currentQuestion && !isset($newQuestionAnswer))
        <div class="p-6 bg-gray-50 border-b">
            <div class="max-w-3xl mx-auto">
                @if ($editingQuestionId === $currentQuestion->id)
                    <div class="space-y-4">
                        <textarea wire:model="editingQuestionText" rows="3" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('editingQuestionText')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="flex space-x-3">
                            <button wire:click="updateQuestion" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                Save Changes
                            </button>
                            <button wire:click="cancelEdit" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <p class="text-xl font-medium text-gray-800 mb-6">
                            {{ $currentQuestion->question_text }}
                        </p>
                        
                        <div class="flex justify-center space-x-4 mb-6">
                            <button wire:click="answerQuestion('yes')"
                                class="px-6 py-2 bg-green-600 text-white rounded-md font-medium hover:bg-green-700 transition-colors">
                                Yes
                            </button>
                            <button wire:click="answerQuestion('no')"
                                class="px-6 py-2 bg-red-600 text-white rounded-md font-medium hover:bg-red-700 transition-colors">
                                No
                            </button>
                        </div>
                        
                        @if (\App\Models\Question::where('yes_question_id', $currentQuestion->id)
                            ->orWhere('no_question_id', $currentQuestion->id)->exists())
                            <button wire:click="previousQuestion" 
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                ← Previous Question
                            </button>
                        @endif
                        
                        <div class="mt-4">
                            <button wire:click="editQuestion({{ $currentQuestion->id }})" 
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                Edit This Question
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- New Question Section -->
    @if($newQuestionAnswer)
        <div class="p-6 bg-white">
            <div class="max-w-3xl mx-auto space-y-4">
                <h3 class="text-lg font-medium text-gray-900">
                    Create new question for 
                    <span class="font-semibold text-blue-600">"{{ ucfirst($newQuestionAnswer) }}"</span> answer
                </h3>
                
                @if ($currentQuestion)
                    <div class="bg-gray-50 p-3 rounded-md">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Previous question:</span> 
                            {{ $currentQuestion->question_text }}
                        </p>
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Enter your question:</label>
                    <textarea wire:model="newQuestionText" rows="3" 
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('newQuestionText')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <button wire:click="createQuestion" 
                    class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save {{ ucfirst($newQuestionAnswer) }} Question
                </button>
            </div>
        </div>
    @endif

    <!-- First Question Section -->
    @if (!$currentQuestion && isset($selectedProblem))
        <div class="p-6 bg-gray-50">
            <div class="max-w-3xl mx-auto space-y-4">
                <h1 class="text-xl font-medium text-gray-900">Create the first question for this problem</h1>
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Enter your question:</label>
                    <textarea wire:model="newQuestionText" rows="3" 
                        class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('newQuestionText')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <button wire:click="createFirstQuestion" 
                    class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save First Question
                </button>
            </div>
        </div>
    @endif
</div>