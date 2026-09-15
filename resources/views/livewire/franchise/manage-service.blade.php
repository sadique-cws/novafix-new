<div class="space-y-6">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search and Actions -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <x-ui.input type="text" wire:model.live="search" placeholder="Search by category name..." />
        </div>
        <div class="w-full md:w-auto shrink-0">
            <x-ui.button wire:click="viewAddModal" class="w-full md:w-auto">
                <i class="fas fa-plus mr-2"></i> Add Category
            </x-ui.button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
            </x-slot>

            @forelse($categories as $category)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">{{ $category->id }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $category->name }}</td>
                    <td class="px-5 py-4 text-sm text-right font-medium">
                        <div class="flex justify-end space-x-3">
                            <button wire:click="startEdit({{ $category->id }})" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </button>
                            <button wire:confirm='Are you sure you want to delete this category?' wire:click="deleteCategory({{ $category->id }})" class="text-red-500 hover:text-red-700 transition" title="Delete">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-5 py-8 text-center text-gray-500">
                        <i class="fas fa-folder-open text-4xl mb-4 text-gray-300 block"></i>
                        No service categories found.
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        @if($categories->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Add/Edit Modal -->
    <x-ui.modal name="serviceModal" title="{{ $editId ? 'Edit Service Category' : 'Add New Service Category' }}">
        <form wire:submit.prevent="addCategory" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <x-ui.input type="text" wire:model="categoryName" placeholder="Enter category name" autofocus />
                @error('categoryName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <x-ui.button type="button" variant="secondary" wire:click="closeModal">Cancel</x-ui.button>
                <x-ui.button type="submit">{{ $editId ? 'Update Category' : 'Add Category' }}</x-ui.button>
            </div>
        </form>
    </x-ui.modal>
</div>