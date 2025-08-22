<div>
    <livewire:admin.components.navigation />
    <div class="p-6 bg-white rounded-lg shadow-sm">
        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 border-l-4 border-green-500 rounded">
                <div class="flex justify-between items-center">
                    <span>{{ session('message') }}</span>
                    <button wire:click="$set('showFlash', false)" class="text-green-700 hover:text-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Device Form Section -->
            <div class="w-full lg:w-3/12">
                <div class="bg-white border border-gray-200 rounded-lg shadow p-5">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">{{ $editingId ? 'Edit' : 'Add' }} Device</h2>
                    <form wire:submit.prevent="{{$editingId ? 'updateDevice' : 'addDevice'}}">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Device Name</label>
                            <input type="text" wire:model="name" placeholder="Enter device name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded transition duration-150">
                                {{ $editingId ? 'Update' : 'Add' }}
                            </button>
                            @if ($editingId)
                                <button type="button" wire:click="resetInput"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded transition duration-150">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Device List Section -->
            <div class="w-full lg:w-9/12">
                <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
                    <div class="flex p-5 justify-between items-center">
                        <h2 class="text-xl font-semibold  text-gray-800 ">Manage Devices</h2>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search Devices...."
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Device Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($devices as $device)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $device->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $device->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex gap-2">
                                                <button wire:click="editDevice({{ $device->id }})"
                                                    class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded transition duration-150">
                                                    Edit
                                                </button>
                                                <button
                                                    wire:click="$dispatch('openConfirmDeleteModal', { id: {{ $device->id }}})"
                                                    class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded transition duration-150">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-5">
                            {{ $devices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        @if ($showDeleteModal)
            <livewire:admin.components.confirm-delete-modal :idToDelete="$idToDelete" />
        @endif
    </div>
</div>