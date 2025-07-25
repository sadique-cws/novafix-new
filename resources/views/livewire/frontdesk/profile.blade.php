<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-blue-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        @if($editing && $tempPhotoUrl)
                            <img src="{{ $tempPhotoUrl }}" class="h-20 w-20 rounded-full object-cover">
                        @elseif($receptionist->photo_path)
                            <img src="{{ asset('storage/'.$receptionist->photo_path) }}" class="h-20 w-20 rounded-full object-cover">
                        @else
                            <div class="h-20 w-20 rounded-full bg-blue-400 flex items-center justify-center text-3xl font-bold">
                                {{ strtoupper(substr($receptionist->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        @if($editing)
                            <label class="absolute bottom-0 right-0 bg-white p-1 rounded-full shadow cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" wire:model="photo" class="hidden">
                            </label>
                        @endif
                    </div>
                    <div>
                        @if($editing)
                            <input wire:model="receptionist.name" type="text" class="text-2xl font-bold bg-blue-500 text-white border-b border-white focus:outline-none">
                        @else
                            <h1 class="text-2xl font-bold">{{ $receptionist->name }}</h1>
                        @endif
                        <p class="text-blue-100">{{ $receptionist->email }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $receptionist->status == '1' ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ $receptionist->status == '1' ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-6">
            @if($successMessage)
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ $successMessage }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Personal Information</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        @if($editing)
                            <input wire:model="receptionist.contact" type="text" class="w-full p-2 border rounded">
                            @error('receptionist.contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <p class="font-medium">{{ $receptionist->contact }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        @if($editing)
                            <textarea wire:model="receptionist.address" class="w-full p-2 border rounded"></textarea>
                            @error('receptionist.address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <p class="font-medium">{{ $receptionist->address }}</p>
                        @endif
                    </div>
                </div>

                <!-- Official Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Official Information</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Salary</p>
                        @if($editing)
                            <input wire:model="receptionist.salary" type="text" class="w-full p-2 border rounded">
                            @error('receptionist.salary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <p class="font-medium">₹{{ number_format($receptionist->salary, 2) }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Franchise ID</p>
                        <p class="font-medium">{{ $receptionist->franchise_id ?? 'Not assigned' }}</p>
                    </div>
                </div>

                <!-- Identity Documents -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Identity Documents</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Aadhar Number</p>
                        @if($editing)
                            <input wire:model="receptionist.aadhar" type="text" class="w-full p-2 border rounded">
                            @error('receptionist.aadhar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <p class="font-medium">{{ $receptionist->aadhar }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">PAN Number</p>
                        @if($editing)
                            <input wire:model="receptionist.pan" type="text" class="w-full p-2 border rounded">
                            @error('receptionist.pan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <p class="font-medium">{{ $receptionist->pan }}</p>
                        @endif
                    </div>
                </div>

                <!-- Account Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Account Information</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        @if($editing)
                            <input wire:model="receptionist.email" type="email" class="w-full p-2 border rounded">
                            @error('receptionist.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <p class="font-medium">{{ $receptionist->email }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Password</p>
                        <p class="font-medium">••••••••</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                @if($editing)
                    <button wire:click="save" wire:loading.attr="disabled" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center">
                        <span wire:loading wire:target="save">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span wire:loading.remove wire:target="save">Save Changes</span>
                    </button>
                    <button wire:click="cancelEdit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        Cancel
                    </button>
                @else
                    <button wire:click="startEditing" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Edit Profile
                    </button>
                    <button wire:click="togglePasswordModal" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        Change Password
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Password Change Modal -->
    @if($showPasswordModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <h2 class="text-xl font-semibold mb-4">Change Password</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input wire:model="current_password" type="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input wire:model="new_password" type="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input wire:model="new_password_confirmation" type="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button wire:click="togglePasswordModal" type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <button wire:click="changePassword" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center">
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