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
                <select wire:model="selectedModel" wire:change="updateSelectedModel"
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
                <select wire:model="selectedProblem" wire:change="updateSelectedProblem"
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

    @if ($currentQuestion && !isset($newQuestionAnswer))
        <div class="mt-5 p-5 rounded border shadow-sm">
            @if ($editingQuestionId === $currentQuestion->id)
                <div class="flex flex-col space-y-3">
                    <input type="text" wire:model="editingQuestionText" class="w-full p-3 border rounded-lg">
                    @error('editingQuestionText')
                        <span class="text-red-500 font-semibold text-sm">{{ $message }}</span>
                    @enderror
                    <div class="flex space-x-3">
                        <button wire:click="updateQuestion" class="px-3 py-2 rounded bg-green-500 text-white">Save</button>
                        <button wire:click="cancelEdit" class="px-3 py-2 rounded bg-gray-400 text-white">Cancel</button>
                    </div>
                </div>
            @else
                <p class="text-2xl font-semibold text-gray-700 leading-snug">
                    {{ $currentQuestion->question_text }}
                </p>
                <div class="flex flex-col space-y-4 items-center">
                    <div class="flex space-x-4">
                        <button wire:click="answerQuestion('yes')"
                            class="font-semibold p-2 rounded bg-green-600 text-white">Yes</button>
                        <button wire:click="answerQuestion('no')"
                            class="font-semibold p-2 rounded bg-red-600 text-white">No</button>
                    </div>
                </div>
                @if (
                        \App\Models\Question::where('yes_question_id', $currentQuestion->id)
                            ->orWhere('no_question_id', $currentQuestion->id)->exists()
                    )
                    <button wire:click="previousQuestion" class="mt-3 px-3 py-2 text-black font-medium">Previous Question</button>

                @endif

                <button wire:click="editQuestion({{ $currentQuestion->id }})" class="mt-3 text-blue-400 transition-all">Edit
                    This Question</button>
            @endif
        </div>
    @endif

    @if($newQuestionAnswer)
        <div class="mt-5 p-6 rounded border shadow-lg">
            <h3>Create New Question for "{{ ucfirst($newQuestionAnswer) }}"</h3>
        </div>

        @if ($currentQuestion)
            <p class="text-sm text-gray-700 rounded-md">
                <strong>Previous Question:</strong>{{ $currentQuestion->question_text }}
            </p>
        @endif

        <div class="mt-4">
            <label for="" class="font-semibold text-lg text-gray-500">Enter The Question:</label>
            <input type="text" wire:model="newQuestionText" class="border p-2 rounded shadow-sm text-lg">
            @error('newQuestionText')
                <span class="text-red-500 font-semibold">{{ $message }}</span>
            @enderror
        </div>
        <button wire:click="createQuestion" class="mt-5 w-full px-3 py-2 bg-blue-600 text-white">Save
            {{ ucfirst($newQuestionAnswer) }} Question</button>
    @endif

    @if (!$currentQuestion && isset($selectedProblem))
        <div class="bg-gray-400 rounded lg p-5 border font-semibold text-lg">
            <h1 class="text-2xl font-semibold text-gray-700 mb-4">Create The first Question for this problem</h1>
            <div class="mt-4">
                <label for="" class="block font-seibold text-lg mb-2">Enter the first Question:</label>
                <input type="text" wire:model="newQuestionText" class="bg-gray-100 border px-3 py-2 rounded-lg">
                @error('newQuestionText')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <button wire:click="createFirstQuestion" class="mt-5 w-full px-3 py-2 rounded border">Save First
                Question</button>
        </div>
    @endif
</div>