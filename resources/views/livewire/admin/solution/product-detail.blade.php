<div>
    <div class="mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Header Section -->
    <div class="flex items-center justify-between p-4 bg-blue-600 text-white">
        <h3 class="text-xl font-bold">Support Diagnosis</h3>
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
                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $selectedDevice ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                {{ $selectedDevice ? 'disabled' : '' }}>
                <option value="">Choose Device</option>
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Brand Selection -->
        @if ($brands)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Brand</label>
                <select wire:model="selectedBrand" wire:change="updateSelectedBrand"
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $selectedBrand ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                    {{ $selectedBrand ? 'disabled' : '' }}>
                    <option value="">Choose Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Model Selection -->
        @if ($models)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Model</label>
                <select wire:model="selectedModel" wire:change="updateSelectedModel"
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $selectedModel ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                    {{ $selectedModel ? 'disabled' : '' }}>
                    <option value="">Choose Model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Problem Selection -->
        @if ($problems)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Problem</label>
                <select wire:model="selectedProblem" wire:change="updateSelectedProblem"
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 {{ $selectedProblem ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                    {{ $selectedProblem ? 'disabled' : '' }}>
                    <option value="">Choose Problem</option>
                    @foreach ($problems as $problem)
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
                        <textarea wire:model="editingQuestionText" rows="3"
                            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('editingQuestionText')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 items-start">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Image (Optional)</label>
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition">
                                        <input type="file" accept="image/*" wire:model="editingQuestionImage"
                                            class="hidden">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="mt-1 text-xs text-gray-500">Upload</span>
                                    </label>
                                    <div wire:loading wire:target="image"
                                        class="mt-1 flex items-center text-blue-600 text-xs">
                                        <svg class="animate-spin -ml-1 mr-1 h-3 w-3 text-blue-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4">
                                            </circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Uploading...
                                    </div>
                                    @error('image')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Preview</label>
                                    @if ($editingQuestionImage)
                                        <div class="relative inline-block">
                                            <img src="{{ $editingQuestionImage }}"
                                                class="h-28 w-full rounded-md border object-cover">
                                            <button type="button" wire:click="$set('image', null)"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition"
                                                aria-label="Remove image">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <div
                                            class="flex items-center justify-center h-28 w-full border border-gray-200 rounded-md bg-gray-50 text-gray-400 text-sm">
                                            No image
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                <textarea wire:model="editingQuestionDescription" rows="5"
                                    class="w-full px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Notes or context..."></textarea>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button wire:click="updateQuestion"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                Save Changes
                            </button>
                            <button wire:click="cancelEdit"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
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

                        @if (\App\Models\Question::where('yes_question_id', $currentQuestion->id)->orWhere('no_question_id', $currentQuestion->id)->exists())
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

    <!-- New Question Creation -->
    @if ($newQuestionAnswer)
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
                {{-- enter Search by Question Text --}}
                <div class="p-6 space-y-5">
                    <!-- Search Section -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="{{ $selectedQuestion ? 'Search different question...' : 'Search by question_text ...' }}"
                            class="block w-full pl-10 pr-12 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @error('selectedQuestion')
                            <p class="font-semibold text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Clear/Loading Indicators -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            @if ($selectedQuestion)
                                <button wire:click="clearSelection"
                                    class="text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @elseif($search && count($allQuestion) === 0 && !$selectedQuestion)
                                    <button wire:click="createNewQuestion"
                                        class="mt-3 px-2 py-1 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 ">
                                        Create New Question
                                    </button>
                            @else
                                <div wire:loading.delay.shortest wire:target="search">
                                    <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($search && count($allQuestion) > 0 && !$selectedQuestion)
                        <div
                            class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto divide-y divide-gray-100">
                            @foreach ($allQuestion as $question)
                                <div wire:click="selectQuestion({{ $question->id }})"
                                    class="p-3 hover:bg-blue-50 cursor-pointer flex justify-between items-center transition-colors duration-150">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium">
                                            {{ substr($question->question_text, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $question->question_text }}
                                            </p>
                                        </div>
                                    </div>
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Selected Question Details or Create New Form -->
                    @if ($selectedQuestion || $creatingNew)
                        <div class="mt-4 bg-white rounded-lg border border-green-100 overflow-hidden shadow-sm">
                            <div class="bg-green-50 px-4 py-2 border-b border-green-100">
                                <h4 class="text-sm font-medium text-green-800 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $selectedQuestion ? 'Selected Question Details' : 'Create New Question' }}
                                </h4>
                            </div>
                            <div class="p-4">
                                @if ($selectedQuestion)
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium text-lg">
                                            {{ substr($selectedQuestion->question_text, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-base font-semibold text-gray-900">
                                                {{ $selectedQuestion->question_text }}
                                            </h4>
                                            @if ($selectedQuestion->description)
                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ $selectedQuestion->description }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($selectedQuestion->image_url)
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700">Image</label>
                                            <img src="{{ $selectedQuestion->image_url }}"
                                                class="mt-2 h-40 rounded-md border object-contain">
                                        </div>
                                    @endif
                                @else
                                    <!-- New Question Form -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Question
                                                Text</label>
                                            <input type="text" wire:model="newQuestionText"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            @error('newQuestionText')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Image
                                                    (Optional)</label>
                                                <label
                                                    class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition">
                                                    <input type="file" accept="image/*" wire:model="image"
                                                        class="hidden">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-6 w-6 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="mt-1 text-xs text-gray-500">Upload</span>
                                                </label>
                                                <div wire:loading wire:target="image"
                                                    class="mt-1 flex items-center text-blue-600 text-xs">
                                                    <svg class="animate-spin -ml-1 mr-1 h-3 w-3 text-blue-500"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12"
                                                            r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    Uploading...
                                                </div>
                                                @error('image')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Preview</label>
                                                @if ($image)
                                                    <div class="relative inline-block">
                                                        <img src="{{ $image->temporaryUrl() }}"
                                                            class="h-28 w-full rounded-md border object-cover">
                                                        <button type="button" wire:click="$set('image', null)"
                                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition"
                                                            aria-label="Remove image">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div
                                                        class="flex items-center justify-center h-28 w-full border border-gray-200 rounded-md bg-gray-50 text-gray-400 text-sm">
                                                        No image selected
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Description
                                                (Optional)</label>
                                            <textarea wire:model="description" rows="3"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                placeholder="Add any additional details..."></textarea>
                                        </div>

                                      
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between">
                    <button wire:click="createQuestion"
                        class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save {{ ucfirst($newQuestionAnswer) }} Question
                    </button>
                   
                    <button wire:click="cancelCreateQuestion"
                        class="bg-gray-400 text-white px-2 py-1 rounded ">Back</button>
                </div>
            </div>
        </div>
    @endif

    <!-- First Question Creation -->
    @if (!$currentQuestion && isset($selectedProblem))
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="pb-4">
                    <h1 class="text-2xl font-semibold text-gray-800">Create First Question</h1>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Question Text <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="newQuestionText" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Enter your question here...">
                    @error('newQuestionText')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 items-start">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image (Optional)</label>
                            <label
                                class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition">
                                <input type="file" accept="image/*" wire:model="image" class="hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="mt-1 text-xs text-gray-500">Upload</span>
                            </label>
                            <div wire:loading wire:target="image"
                                class="mt-1 flex items-center text-blue-600 text-xs">
                                <svg class="animate-spin -ml-1 mr-1 h-3 w-3 text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Uploading...
                            </div>
                            @error('image')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Preview</label>
                            @if ($image)
                                <div class="relative inline-block">
                                    <img src="{{ $image->temporaryUrl() }}"
                                        class="h-28 w-full rounded-md border object-cover">
                                    <button type="button" wire:click="$set('image', null)"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition"
                                        aria-label="Remove image">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div
                                    class="flex items-center justify-center h-28 w-full border border-gray-200 rounded-md bg-gray-50 text-gray-400 text-sm">
                                    No image
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                        <textarea wire:model="description" rows="5"
                            class="w-full px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="Notes or context..."></textarea>
                    </div>
                </div>
                <div class="pt-4">
                    <button wire:click="createFirstQuestion" wire:loading.attr="disabled"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <span wire:loading.remove wire:target="createFirstQuestion">Create Question</span>
                        <span wire:loading wire:target="createFirstQuestion">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

</div>