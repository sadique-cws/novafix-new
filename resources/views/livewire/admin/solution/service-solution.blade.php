<div>
    <livewire:admin.components.navigation />
    <div class="mx-auto mt-5 bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header Section -->
        <div class="flex items-center justify-between px-4 py-3 bg-[#1E40AF] text-[#F9FAFB]">
            <h3 class="text-xl font-medium">Admin Diagnosis</h3>
            <button wire:click="resetSelection"
                class="px-3 py-1 bg-[#F9FAFB] text-[#1E40AF] rounded-md text-sm font-medium hover:bg-blue-50 transition-colors">
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
                            <div class="flex flex-col gap-1">
                                <label class="block text-sm font-medium text-gray-700">Question</label>
                                <input type="text" wire:model="editingQuestionText" rows="3"
                                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('editingQuestionText')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
                                                @if (is_string($editingQuestionImage))
                                                    <img src="{{ $editingQuestionImage }}"
                                                        class="h-28 w-full rounded-md border object-cover">
                                                @else
                                                    <img src="{{ $editingQuestionImage->temporaryUrl() }}"
                                                        class="h-28 w-full rounded-md border object-cover">
                                                @endif
                                                <div class="absolute -top-2 -right-2 flex space-x-2">
                                                    @if (is_string($editingQuestionImage))
                                                        {{-- Persisted image: remove from DB/provider --}}
                                                        <button type="button"
                                                            wire:click.prevent="removeEditingImageNow"
                                                            class="bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition"
                                                            aria-label="Remove persisted image">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    @else
                                                        {{-- Temporary uploaded file: just clear the selection --}}
                                                        <button type="button"
                                                            wire:click.prevent="$set('editingQuestionImage', null)"
                                                            class="bg-yellow-500 text-white rounded-full p-1 hover:bg-yellow-600 transition"
                                                            aria-label="Clear selection">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
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
                                    <label class="block text-sm font-medium text-gray-700">Description
                                        (Optional)</label>
                                    <textarea wire:model="editingQuestionDescription" rows="5"
                                        class="w-full px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        placeholder="Notes or context..."></textarea>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <button wire:click="updateQuestion"
                                    class="px-4 py-2 flex items-center gap-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                    <i class="fa-regular fa-circle-check"></i>
                                    <span>Save Changes</span>
                                </button>
                                <button wire:click="cancelEdit"
                                    class="px-4 py-2 bg-gray-500 flex items-center gap-2 text-white rounded-md hover:bg-gray-600 transition-colors">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                    <span>Cancel</span>
                                </button>
                            </div>
                        </div>
                    @else
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

                                <div class="mt-4">
                                    <button wire:click="editQuestion({{ $currentQuestion->id }})"
                                        class="text-blue-600 mt-1 hover:text-blue-800 text-lg font-medium transition-colors">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit This Question</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Extra Section (Image + Description) -->
                            @if ($currentQuestion->image_url || $currentQuestion->description)
                                <div
                                    class="flex flex-col items-center md:items-start gap-3 md:w-1/3 text-center md:text-left">
                                    @if ($currentQuestion->image_url)
                                        <div class="flex flex-col gap-1">
                                            <p
                                                class=" text-gray-700
                                                                                                                                                                                             font-medium">
                                                Related Image
                                                :-</p>
                                            <img src="{{ $currentQuestion->image_url }}"
                                                class="h-32 w-64 object-fit rounded shadow" alt="Question Image">
                                        </div>
                                    @endif
                                    @if ($currentQuestion->description)
                                        <div class="flex flex-col gap-1">
                                            <label for=""
                                                class="text-gray-700
                                                                                                                                                                                             font-medium">Explanation
                                                :-</label>
                                            <p class="text-gray-700 text-base leading-relaxed">
                                                {{ $currentQuestion->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                    @endif
                </div>
            </div>
        @endif

        <!-- create new question -->
        @if ($newQuestionAnswer)
            <div class="p-6 bg-gray-50 min-h-screen">
                <div class="max-w-5xl mx-auto space-y-6">

                    <!-- Heading -->
                    <h3 class="text-2xl font-semibold text-gray-900">
                        Create new question for
                        <span class="font-bold text-blue-600">"{{ ucfirst($newQuestionAnswer) }}"</span> answer
                    </h3>

                    <!-- Previous Question -->
                    @if ($currentQuestion)
                        <div class="bg-white p-4 rounded-lg shadow-sm border">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium text-gray-900">Previous question:</span>
                                {{ $currentQuestion->question_text }}
                            </p>
                        </div>
                    @endif

                    <!-- Create New Question Btn -->
                    <button wire:click="createNewQuestion"
                        class="px-6 py-3 w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-medium rounded-lg shadow-md hover:from-blue-700 hover:to-blue-600 transition">
                        + Create New Question
                    </button>

                    <!-- Filters Section -->
                    <div class="bg-white p-4 rounded-lg shadow border">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Brand -->
                            @if ($brands)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                    <select wire:model="selectedFilterBrand" wire:change="updateSelectedFilterBrand"
                                        class="w-full p-2.5 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Choose Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Model -->
                            @if ($filterModels)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                                    <select wire:model="selectedFilterModel" wire:change="updateSelectedFilterModel"
                                        class="w-full p-2.5 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Choose Model</option>
                                        @foreach ($filterModels as $model)
                                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Problem -->
                            @if ($filterProblems)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Problem</label>
                                    <select wire:model="selectedFilterProblem"
                                        wire:change="updateSelectedFilterProblem"
                                        class="w-full p-2.5 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Choose Problem</option>
                                        @foreach ($filterProblems as $problem)
                                            <option value="{{ $problem->id }}">{{ $problem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Question -->
                            @if ($filterQuestions)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                                    <select wire:model="selectedQuestion"
                                        wire:change="selectQuestion($event.target.value)"
                                        class="w-full p-2.5 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Choose Question</option>
                                        @foreach ($filterQuestions as $question)
                                            <option value="{{ $question->id }}">{{ $question->question_text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <!-- Search -->
                        <div class="mt-4 relative">
                            <span class="absolute left-3 top-3 text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="{{ $selectedQuestion ? 'Search different question...' : 'Search by question text...' }}"
                                class="w-full pl-10 pr-12 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute right-3 top-2.5" wire:loading.delay.shortest wire:target="search">
                                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Question Details / Create New -->
                    @if ($selectedQuestion || $creatingNew)
                        <div class="bg-white rounded-xl border shadow p-6">
                            <div class="flex justify-between items-center border-b pb-3 mb-4">
                                <h4 class="text-lg font-semibold text-green-700 flex items-center gap-2">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $selectedQuestion ? 'Selected Question' : 'Create New Question' }}
                                </h4>
                                <button wire:click="{{ $selectedQuestion ? 'clearSelection' : 'cancelCreate' }}"
                                    class="text-gray-400 hover:text-red-500">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>

                            @if ($selectedQuestion)
                                <!-- Selected Question View -->
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                        {{ substr($selectedQuestion->question_text, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900">
                                            {{ $selectedQuestion->question_text }}</h4>
                                        @if ($selectedQuestion->description)
                                            <p class="mt-1 text-sm text-gray-600">{{ $selectedQuestion->description }}
                                            </p>
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
                                <!-- Create Form -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Question Text</label>
                                        <input type="text" wire:model="newQuestionText"
                                            class="mt-1 block w-full border rounded-md py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500">
                                        @error('newQuestionText')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Upload + Preview -->
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Image
                                                (Optional)</label>
                                            <label
                                                class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition">
                                                <input type="file" accept="image/*" wire:model="image"
                                                    class="hidden">
                                                <i class="fa-solid fa-upload text-gray-400 text-xl"></i>
                                                <span class="mt-1 text-xs text-gray-500">Upload</span>
                                            </label>
                                            <div wire:loading wire:target="image"
                                                class="mt-1 text-xs text-blue-600 flex items-center gap-1">
                                                <i class="fa-solid fa-spinner animate-spin"></i> Uploading...
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
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div
                                                    class="flex items-center justify-center h-28 w-full border rounded-md bg-gray-50 text-gray-400 text-sm">
                                                    No image selected
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description
                                            (Optional)</label>
                                        <textarea wire:model="description" rows="3"
                                            class="mt-1 block w-full border rounded-md py-2 px-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Add additional details..."></textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-4">
                        <button wire:click="createQuestion"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md text-sm">
                            Save {{ ucfirst($newQuestionAnswer) }} Question
                        </button>
                        <button wire:click="cancelCreateQuestion"
                            class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg text-sm">
                            Back
                        </button>
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
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
