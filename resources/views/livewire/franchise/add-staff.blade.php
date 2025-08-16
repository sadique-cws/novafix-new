<div>
    <div class="container mx-auto  py-2 max-w-6xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Add New Staff Member</h2>
        </div>

        <!-- Success/Error Messages -->
        <div class="px-6 pt-4">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <form wire:submit.prevent="save" enctype="multipart/form-data" class="p-3">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                <!-- Left Column - Profile Section -->
                <div class="lg:col-span-1">
                    <div class="space-y-2">
                        <!-- Profile Card -->
                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-100">
                            <h3 class="text-lg font-medium text-blue-800 mb-4">Profile Information</h3>
                            
                            <!-- Profile Image Upload -->
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <div class="h-32 w-32 rounded-full overflow-hidden border-4 border-white shadow-md bg-gray-100">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" alt="Profile preview"
                                                class="h-full w-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($name ?? 'Staff') }}&color=7F9CF5&background=EBF4FF"
                                                alt="Profile preview" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <label for="image" class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <input type="file" id="image" wire:model="image" class="hidden">
                                    </label>
                                </div>
                                <p class="mt-3 text-sm text-gray-500 text-center">JPG, PNG or GIF (Max 2MB)</p>
                                @error('image')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Status Toggle -->
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                                <div class="flex items-center">
                                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                        <input type="checkbox" id="statusToggle" wire:model="status" 
                                               class="sr-only toggle-checkbox" 
                                               :value="'active'" 
                                               :checked="$status === 'active'">
                                        <label for="statusToggle" class="block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out
                                            {{ $status === 'active' ? 'bg-green-500' : '' }}">
                                            <span class="dot absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 ease-in-out
                                                {{ $status === 'active' ? 'translate-x-4' : '' }}"></span>
                                        </label>
                                    </div>
                                    <span class="text-sm font-medium {{ $status === 'active' ? 'text-green-600' : 'text-gray-600' }}">
                                        {{ $status === 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                @error('status')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Login Credentials Card -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Login Credentials</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                            </svg>
                                        </div>
                                        <input type="email" wire:model="email" id="email" placeholder="staff@example.com"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('email')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <input type="password" wire:model="password" id="password" placeholder="••••••••"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('password')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Form Fields -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- Personal Information Card -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="name" id="name" placeholder="John Doe"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('name')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="contact" id="contact" placeholder="+91 9876543210"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('contact')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <textarea wire:model="address" id="address" rows="3" placeholder="123 Main St, City, State, ZIP"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                    @error('address')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Employment Details Card -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Employment Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="service_categories_id" class="block text-sm font-medium text-gray-700 mb-1">Service Category</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <select wire:model="service_categories_id" id="service_categories_id"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('service_categories_id')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Monthly Salary</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">₹</span>
                                        </div>
                                        <input type="number" wire:model="salary" id="salary" placeholder="25000"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('salary')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Document Details Card -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Document Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="aadhar" class="block text-sm font-medium text-gray-700 mb-1">Aadhar Number</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="aadhar" id="aadhar" placeholder="1234 5678 9012"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('aadhar')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="pan" class="block text-sm font-medium text-gray-700 mb-1">PAN Number</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z"/>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="pan" id="pan" placeholder="ABCDE1234F"
                                            class="pl-10 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    @error('pan')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                <button type="button" wire:click="$emit('closeModal')"
                    class="px-6 py-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out relative"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Add Staff Member</span>
                    <span wire:loading>
                        <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div wire:loading.flex wire:target="save" class="fixed p-6  inset-0 bg-black bg-opacity-30 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full text-center">
        <div class="flex justify-center mb-4">
            <svg class="animate-spin h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-800 mb-2">Adding Staff Member</h3>
        <p class="text-gray-600">Please wait while we save the staff details...</p>
        <div class="mt-4 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 rounded-full animate-pulse" style="width: 60%"></div>
        </div>
    </div>
</div>
</div>