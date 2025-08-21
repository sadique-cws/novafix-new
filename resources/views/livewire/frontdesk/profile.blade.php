<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 md:p-6 text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="relative">
                        @if($receptionist->photo_path)
                            <img src="{{ asset('storage/'.$receptionist->photo_path) }}" 
                                 class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover border-2 border-white shadow-md">
                        @else
                            <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-blue-400 flex items-center justify-center text-2xl sm:text-3xl  text-white border-2 border-white shadow-md">
                                {{ strtoupper(substr($receptionist->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl ">{{ $receptionist->name }}</h1>
                        <p class="text-blue-100 text-sm sm:text-base">{{ $receptionist->email }}</p>
                        <div class="mt-1 sm:hidden">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $receptionist->status == '1' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $receptionist->status == '1' ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $receptionist->status == '1' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $receptionist->status == '1' ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Personal Information Card -->
                <div class="bg-gray-50 rounded-lg p-4 md:p-5 shadow-sm border border-gray-100">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Personal Information
                    </h2>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Contact Number</p>
                            <p class="font-medium text-sm sm:text-base">{{ $receptionist->contact }}</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Address</p>
                            <p class="font-medium text-sm sm:text-base">{{ $receptionist->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Official Information Card -->
                <div class="bg-gray-50 rounded-lg p-4 md:p-5 shadow-sm border border-gray-100">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                        Official Information
                    </h2>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Salary</p>
                            <p class="font-medium text-sm sm:text-base">₹{{ number_format($receptionist->salary, 2) }}</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Franchise Name</p>
                            <p class="font-medium text-sm sm:text-base">{{ $receptionist->franchise->franchise_name ?? 'Not assigned' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Identity Documents Card -->
                <div class="bg-gray-50 rounded-lg p-4 md:p-5 shadow-sm border border-gray-100">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1z" />
                            <path fill-rule="evenodd" d="M4 4a3 3 0 013-3h6a3 3 0 013 3v2a3 3 0 01-3 3h-1v1a3 3 0 01-3 3H8a3 3 0 01-3-3H4a3 3 0 01-3-3V4zm3 2a1 1 0 00-1 1v1a1 1 0 001 1h1a1 1 0 001-1V7a1 1 0 00-1-1H7zm3 0a1 1 0 00-1 1v1a1 1 0 001 1h1a1 1 0 001-1V7a1 1 0 00-1-1h-1zm-3 4a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-1zm4-1a1 1 0 00-1 1v1a1 1 0 001 1h1a1 1 0 001-1v-1a1 1 0 00-1-1h-1z" clip-rule="evenodd" />
                            <path d="M17 9a1 1 0 10-2 0v1a1 1 0 002 0V9z" />
                            <path fill-rule="evenodd" d="M5 15a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        Identity Documents
                    </h2>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Aadhar Number</p>
                            <p class="font-medium text-sm sm:text-base">{{ $receptionist->aadhar }}</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">PAN Number</p>
                            <p class="font-medium text-sm sm:text-base">{{ $receptionist->pan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Information Card -->
                <div class="bg-gray-50 rounded-lg p-4 md:p-5 shadow-sm border border-gray-100">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        Account Information
                    </h2>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Email</p>
                            <p class="font-medium text-sm sm:text-base">{{ $receptionist->email }}</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <p class="text-xs sm:text-sm text-gray-500">Password</p>
                            <p class="font-medium text-sm sm:text-base">••••••••</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
                <button wire:click="togglePasswordModal" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center justify-center space-x-2 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Change Password</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    @if($showPasswordModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 transition-opacity duration-300">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-100">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Change Password</h2>
                    <button wire:click="togglePasswordModal" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <div class="relative">
                            <input wire:model="current_password" type="password" 
                                   class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('current_password') 
                                <span class="absolute right-3 top-2.5 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @enderror
                        </div>
                        @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <div class="relative">
                            <input wire:model="new_password" type="password" 
                                   class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @error('new_password') 
                                <span class="absolute right-3 top-2.5 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @enderror
                        </div>
                        @error('new_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input wire:model="new_password_confirmation" type="password" 
                               class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <button wire:click="togglePasswordModal" type="button" 
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition shadow-sm">
                        Cancel
                    </button>
                    <button wire:click="changePassword" wire:loading.attr="disabled" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
                        <span wire:loading wire:target="changePassword">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span wire:loading.remove wire:target="changePassword">Update Password</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>