<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-blue-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        @if($receptionist->photo_path)
                            <img src="{{ asset('storage/'.$receptionist->photo_path) }}" class="h-20 w-20 rounded-full object-cover">
                        @else
                            <div class="h-20 w-20 rounded-full bg-blue-400 flex items-center justify-center text-3xl font-bold">
                                {{ strtoupper(substr($receptionist->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $receptionist->name }}</h1>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Personal Information</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="font-medium">{{ $receptionist->contact }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium">{{ $receptionist->address }}</p>
                    </div>
                </div>

                <!-- Official Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Official Information</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Salary</p>
                        <p class="font-medium">₹{{ number_format($receptionist->salary, 2) }}</p>
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
                        <p class="font-medium">{{ $receptionist->aadhar }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">PAN Number</p>
                        <p class="font-medium">{{ $receptionist->pan }}</p>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Account Information</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $receptionist->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Password</p>
                        <p class="font-medium">••••••••</p>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-8 flex justify-end">
                <button wire:click="togglePasswordModal" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Change Password
                </button>
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