<div class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Fixed-position loader that centers perfectly on screen -->
   <div wire:loading.flex class="fixed md:p-[25%] inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-xl text-center max-w-md mx-auto">
            <svg class="animate-spin h-10 w-10 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-4 text-gray-700 font-medium">Updating staff information...</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Staff Member</h2>

        <form wire:submit.prevent="updateStaff">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" id="name" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           wire:loading.attr="disabled">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email" id="email" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           wire:loading.attr="disabled">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Contact -->
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                    <input type="text" wire:model="contact" id="contact" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           wire:loading.attr="disabled">
                    @error('contact') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Salary -->
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                    <input type="number" wire:model="salary" id="salary" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           wire:loading.attr="disabled">
                    @error('salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Service Category -->
                <div>
                    <label for="service_categories_id" class="block text-sm font-medium text-gray-700">Service Category</label>
                    <select wire:model="service_categories_id" id="service_categories_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            wire:loading.attr="disabled">
                        @foreach($serviceCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('service_categories_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-1 flex space-x-4">
                        <div class="flex items-center">
                            <input wire:model="status" id="status_active" type="radio" value="active" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                   wire:loading.attr="disabled">
                            <label for="status_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model="status" id="status_inactive" type="radio" value="inactive" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                   wire:loading.attr="disabled">
                            <label for="status_inactive" class="ml-2 block text-sm text-gray-700">Inactive</label>
                        </div>
                    </div>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Aadhar -->
                <div>
                    <label for="aadhar" class="block text-sm font-medium text-gray-700">Aadhar Number</label>
                    <input type="text" wire:model="aadhar" id="aadhar" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           wire:loading.attr="disabled">
                    @error('aadhar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- PAN -->
                <div>
                    <label for="pan" class="block text-sm font-medium text-gray-700">PAN Number</label>
                    <input type="text" wire:model="pan" id="pan" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           wire:loading.attr="disabled">
                    @error('pan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                    <input type="file" wire:model="image" id="image" 
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                           wire:loading.attr="disabled">
                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    @if($staff->image && !$image)
                        <p class="mt-2 text-sm text-gray-500">Current image: <a href="{{ asset('storage/'.$staff->image) }}" target="_blank" class="text-indigo-600 hover:underline">View</a></p>
                    @endif
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea wire:model="address" id="address" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              wire:loading.attr="disabled"></textarea>
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center justify-center min-w-32"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Update Staff</span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Updating...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>