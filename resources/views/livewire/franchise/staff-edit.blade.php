<div class="container mx-auto  py-2 sm:py-8 max-w-6xl">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div wire:loading.flex class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-30 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-xl shadow-lg text-center max-w-sm mx-4 sm:mx-auto">
            <div class="flex justify-center">
                <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <p class="mt-4 text-gray-700 font-medium">Updating staff information...</p>
            <p class="mt-1 text-sm text-gray-500">Please wait while we save your changes</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-5 sm:px-8">
            <div class="flex items-center justify-between">
                <h2 class="text-xl sm:text-2xl font-bold text-white">Edit Staff Member</h2>
                <div class="hidden sm:block bg-indigo-500 text-white text-sm font-medium px-3 py-1 rounded-full">
                    ID: {{ $staff->id }}
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-6 sm:p-8">
            <form wire:submit.prevent="updateStaff">
                <div class="space-y-6">
                    <!-- Personal Information Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" wire:model="name" id="name" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border"
                                       placeholder="John Doe"
                                       wire:loading.attr="disabled">
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" wire:model="email" id="email" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border"
                                       placeholder="john@example.com"
                                       wire:loading.attr="disabled">
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Contact -->
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                <input type="text" wire:model="contact" id="contact" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border"
                                       placeholder="+91 9876543210"
                                       wire:loading.attr="disabled">
                                @error('contact') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Salary -->
                            <div>
                                <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Salary (₹) *</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" wire:model="salary" id="salary" 
                                           class="block w-full pl-8 pr-12 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border"
                                           placeholder="25000"
                                           wire:loading.attr="disabled">
                                </div>
                                @error('salary') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Professional Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Service Category -->
                            <div>
                                <label for="service_categories_id" class="block text-sm font-medium text-gray-700 mb-1">Service Category *</label>
                                <select wire:model="service_categories_id" id="service_categories_id" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border bg-white"
                                        wire:loading.attr="disabled">
                                    <option value="">Select a category</option>
                                    @foreach($serviceCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_categories_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="inline-flex items-center p-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 cursor-pointer">
                                        <input wire:model="status" type="radio" name="status" value="active" 
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                               wire:loading.attr="disabled">
                                        <span class="ml-2 text-sm text-gray-700">Active</span>
                                    </label>
                                    <label class="inline-flex items-center p-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 cursor-pointer">
                                        <input wire:model="status" type="radio" name="status" value="inactive" 
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                               wire:loading.attr="disabled">
                                        <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                    </label>
                                </div>
                                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Identification Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Identification</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Aadhar -->
                            <div>
                                <label for="aadhar" class="block text-sm font-medium text-gray-700 mb-1">Aadhar Number</label>
                                <input type="text" wire:model="aadhar" id="aadhar" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border"
                                       placeholder="1234 5678 9012"
                                       wire:loading.attr="disabled">
                                @error('aadhar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- PAN -->
                            <div>
                                <label for="pan" class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                                <input type="text" wire:model="pan" id="pan" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border uppercase"
                                       placeholder="ABCDE1234F"
                                       wire:loading.attr="disabled">
                                @error('pan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Profile Image</h3>
                        <div class="space-y-4">
                            @if($staff->image && !$image)
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-16 w-16 rounded-full object-cover border-2 border-gray-200" src="{{ asset('storage/'.$staff->image) }}" alt="Current profile photo">
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Current profile image</p>
                                        <a href="{{ asset('storage/'.$staff->image) }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View full size</a>
                                    </div>
                                </div>
                            @endif
                            
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload new image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="image" name="image" type="file" wire:model="image" class="sr-only" wire:loading.attr="disabled">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Address</h3>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                            <textarea wire:model="address" id="address" rows="3" 
                                      class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-4 border"
                                      placeholder="123 Main St, City, State, PIN"
                                      wire:loading.attr="disabled"></textarea>
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-5 border-t border-gray-200 flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center gap-4">
                    <a href="{{ route('franchise.manage.staff') }}" class="inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Staff List
                    </a>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" wire:click="resetForm" class="inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Reset Form
                        </button>
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-32">
                            <span wire:loading.remove wire:target="updateStaff">
                                Update Staff
                            </span>
                            <span wire:loading wire:target="updateStaff" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>