<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Receptionist Details</h2>
            <a wire:navigate href="{{ route('franchise.manage.receptioners') }}"
                class="mt-4 md:mt-0 inline-block px-6 py-3 bg-gray-700 text-white rounded-lg font-semibold shadow-md hover:bg-gray-800 transition duration-300">
                ← Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Personal Information -->
            <section class="bg-gray-50 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-3">Personal Information
                </h3>
                <dl class="space-y-5 text-gray-700">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $receptionist->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-lg text-gray-800 truncate">{{ $receptionist->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $receptionist->contact }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Aadhar Number</dt>
                        <dd class="mt-1 text-lg text-gray-800 tracking-widest">{{ $receptionist->aadhar }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">PAN Number</dt>
                        <dd class="mt-1 text-lg text-gray-800 uppercase tracking-wide">{{ $receptionist->pan }}</dd>
                    </div>
                </dl>
            </section>

            <!-- Employment Details -->
            <section class="bg-gray-50 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-3">Employment Details
                </h3>
                <dl class="space-y-5 text-gray-700">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Salary</dt>
                        <dd class="mt-1 text-lg font-semibold text-indigo-700">
                            ₹{{ number_format($receptionist->salary, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                {{ $receptionist->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $receptionist->status ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Joined On</dt>
                        <dd class="mt-1 text-lg text-gray-900 font-medium">
                            {{ $receptionist->created_at->format('d M Y') }}</dd>
                    </div>
                </dl>
            </section>

            <!-- Address -->
            <section class="bg-gray-50 rounded-lg p-6 shadow-sm md:col-span-2">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-3">Address</h3>
                <p class="text-gray-800 whitespace-pre-line text-lg leading-relaxed">{{ $receptionist->address }}</p>
            </section>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row justify-end gap-4">
            <button wire:click="$toggle('showEditModal')"
                class="w-full sm:w-auto px-6 py-3 text-center bg-indigo-600 text-white rounded-lg font-semibold shadow-md 
          hover:bg-indigo-700 transition duration-300">
                Edit
            </button>
            <button wire:click="confirmDelete({{ $receptionist->id }})" type="button"
                class="w-full sm:w-auto px-6 py-3 text-center bg-red-600 text-white rounded-lg font-semibold shadow-md 
                hover:bg-red-700 transition duration-300">
                Delete
            </button>
        </div>
    </div>

    <!-- Edit Modal -->
    @if ($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Receptionist</h3>
                        <button wire:click="$toggle('showEditModal')" class="text-gray-500 hover:text-gray-700"
                            @if ($isUpdating) disabled @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Loading Overlay -->
                    <!-- Loading Overlay -->
                    @if ($isUpdating)
                        <div
                            class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center rounded-xl z-10">
                            <div class="text-center">
                                <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <p class="mt-2 text-gray-600">Saving changes...</p>
                            </div>
                        </div>
                    @endif

                    <!-- Edit Form -->
                    <form wire:submit.prevent="updateReceptionist">
                        <div class="space-y-4"
                            @if ($isUpdating) style="opacity: 0.5; pointer-events: none;" @endif>
                            <!-- Name -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" wire:model="name" id="name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @if ($isUpdating) disabled @endif>
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" wire:model="email" id="email"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @if ($isUpdating) disabled @endif>
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="contact"
                                        class="block text-sm font-medium text-gray-700">Contact</label>
                                    <input type="text" wire:model="contact" id="contact"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @if ($isUpdating) disabled @endif>
                                    @error('contact')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Aadhar -->
                                <div>
                                    <label for="aadhar" class="block text-sm font-medium text-gray-700">Aadhar
                                        Number</label>
                                    <input type="text" wire:model="aadhar" id="aadhar"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @if ($isUpdating) disabled @endif>
                                    @error('aadhar')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- PAN -->
                            <div>
                                <label for="pan" class="block text-sm font-medium text-gray-700">PAN
                                    Number</label>
                                <input type="text" wire:model="pan" id="pan"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    @if ($isUpdating) disabled @endif>
                                @error('pan')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Salary -->
                                <div>
                                    <label for="salary"
                                        class="block text-sm font-medium text-gray-700">Salary</label>
                                    <input type="number" wire:model="salary" id="salary"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @if ($isUpdating) disabled @endif>
                                    @error('salary')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea wire:model="address" id="address" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @if ($isUpdating) disabled @endif></textarea>
                                    @error('address')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                          <div class="flex items-center space-x-6">
    <!-- Active Radio Button -->
    <div class="flex items-center">
        <input wire:model="status" id="status_active" type="radio" value="1"
            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
            @if($isUpdating) disabled @endif>
        <label for="status_active" class="ml-2 block text-sm text-gray-700">Active</label>
    </div>
    
    <!-- Inactive Radio Button -->
    <div class="flex items-center">
        <input wire:model="status" id="status_inactive" type="radio" value="0"
            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
            @if($isUpdating) disabled @endif>
        <label for="status_inactive" class="ml-2 block text-sm text-gray-700">Inactive</label>
    </div>
</div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" wire:click="$toggle('showEditModal')"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
                                    @if ($isUpdating) disabled @endif>
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center justify-center min-w-24"
                                    @if ($isUpdating) disabled @endif>
                                    @if ($isUpdating)
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Saving...
                                    @else
                                        Save Changes
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
