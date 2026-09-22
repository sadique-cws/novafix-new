<!-- livewire/admin/solution/manage-problem.blade.php -->
<div>
    <livewire:admin.components.navigation />
    
    <div class="mt-5 space-y-5">
        <!-- Flash Message -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" class="p-4 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl shadow-2xs flex items-center justify-between transition-all">
                <div class="flex items-center gap-2.5">
                    <div class="p-1 rounded-full bg-emerald-100 text-emerald-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('message') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-800 hover:bg-emerald-100 p-1.5 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <!-- Add / Edit Problem Form -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-xl shadow-2xs border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-lg {{ $editingProblemId ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </span>
                            <h2 class="text-sm font-bold text-slate-800">
                                {{ $editingProblemId ? 'Edit Problem' : 'Add New Problem' }}
                            </h2>
                        </div>
                        @if($editingProblemId)
                            <span class="text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                Editing #{{ $editingProblemId }}
                            </span>
                        @endif
                    </div>

                    <form class="p-5 space-y-4" wire:submit.prevent="{{ $editingProblemId ? 'updateProblem' : 'saveProblem' }}">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-700">Select Model <span class="text-rose-500">*</span></label>
                            <select wire:model="model_id"
                                class="block w-full px-3 py-2 text-xs sm:text-sm border border-slate-300 rounded-lg shadow-2xs bg-white text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                                <option value="">Select Model</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            @error('model_id') <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-700">Problem Name <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="name" placeholder="e.g. No Network Signal"
                                class="block w-full px-3 py-2 text-xs sm:text-sm border border-slate-300 rounded-lg shadow-2xs bg-white text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            @error('name') <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2 flex items-center gap-2">
                            <button type="submit"
                                class="flex-1 inline-flex justify-center items-center py-2 px-4 rounded-lg shadow-2xs text-xs sm:text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                {{ $editingProblemId ? 'Update Problem' : 'Save Problem' }}
                            </button>
                            @if($editingProblemId)
                                <button type="button" wire:click="cancelEdit"
                                    class="py-2 px-4 border border-slate-300 rounded-lg shadow-2xs text-xs sm:text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-300 transition">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Problems Table -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-xl shadow-2xs border border-slate-200 overflow-hidden">
                    <!-- Table Card Header -->
                    <div class="bg-slate-50 px-5 py-3.5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-bold text-slate-800">Manage Problems</h2>
                            <span class="inline-flex items-center text-[11px] font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">
                                {{ $problems->total() }} total
                            </span>
                        </div>
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search problems..."
                                class="block w-full pl-9 pr-3 py-1.5 text-xs sm:text-sm rounded-lg border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                        </div>
                    </div>

                    <!-- Table Content with Distinct Visible Borders -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse">
                            <thead class="bg-slate-50">
                                <tr class="border-b border-slate-200">
                                    <th scope="col" class="px-5 py-3 text-left text-[11px] font-bold text-slate-600 uppercase tracking-wider w-16 border-b border-slate-200">
                                        ID
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-left text-[11px] font-bold text-slate-600 uppercase tracking-wider border-b border-slate-200">
                                        Model / Brand
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-left text-[11px] font-bold text-slate-600 uppercase tracking-wider border-b border-slate-200">
                                        Problem Description
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-right text-[11px] font-bold text-slate-600 uppercase tracking-wider w-24 border-b border-slate-200">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($problems as $problem)
                                    <tr class="border-b border-slate-200 hover:bg-blue-50/30 transition-colors">
                                        <td class="px-5 py-3.5 whitespace-nowrap border-b border-slate-200">
                                            <span class="font-mono text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                                #{{ $problem->id }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap border-b border-slate-200">
                                            <div class="space-y-0.5">
                                                <div class="text-xs sm:text-sm font-semibold text-slate-800">
                                                    {{ $problem->model->name ?? 'N/A' }}
                                                </div>
                                                <span class="inline-flex items-center text-[10px] font-medium text-slate-500 bg-slate-100 px-1.5 py-0.2 rounded border border-slate-200">
                                                    {{ $problem->model->brand->name ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 border-b border-slate-200">
                                            <div class="flex items-center gap-2">
                                                <span class="h-1.5 w-1.5 rounded-full bg-blue-600 shrink-0"></span>
                                                <span class="text-xs sm:text-sm font-medium text-slate-800">{{ $problem->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap text-right border-b border-slate-200">
                                            <div class="flex items-center justify-end gap-1">
                                                <button wire:click="editProblem({{ $problem->id }})"
                                                    title="Edit Problem"
                                                    class="p-1.5 rounded-md text-slate-400 hover:text-amber-600 hover:bg-amber-50 border border-transparent hover:border-amber-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </button>
                                                <button wire:click="deleteProblem({{ $problem->id }})"
                                                    title="Delete Problem"
                                                    onclick="confirm('Are you sure you want to delete this problem?') || event.stopImmediatePropagation()"
                                                    class="p-1.5 rounded-md text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center border-b border-slate-200">
                                            <div class="max-w-sm mx-auto space-y-2">
                                                <div class="h-10 w-10 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-semibold text-slate-700">No problems found</p>
                                                <p class="text-xs text-slate-400">Try adjusting your search query or add a new problem using the form.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($problems->hasPages())
                        <div class="bg-slate-50 px-5 py-3 border-t border-slate-200">
                            {{ $problems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>