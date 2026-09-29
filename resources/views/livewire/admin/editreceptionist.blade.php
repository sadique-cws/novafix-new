<div class="min-h-screen bg-gray-50 py-4 px-3 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Gradient Header (Back button removed) -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-6 sm:px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($name ?? 'R', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit Receptionist</h2>
                        <p class="text-blue-100 text-sm mt-0.5">Update personal details, contact info and employment status</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="update" class="p-6 sm:p-8 space-y-8">
                <!-- Section 1: Personal & Contact Information -->
                <div>
                    <div class="flex items-center mb-6 pb-2 border-b border-gray-100">
                        <div class="bg-blue-100 p-2 rounded-lg mr-3 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Personal & Contact Details</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="name" wire:model.live="name"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="Enter full name">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-regular fa-user text-sm"></i>
                                </div>
                            </div>
                            @error('name') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Contact -->
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="contact" maxlength="10" wire:model.live="contact"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="10-digit mobile number">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </div>
                            </div>
                            @error('contact') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="email" id="email" wire:model.live="email"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="receptionist@example.com">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                            </div>
                            @error('email') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" wire:model.live="status"
                                class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 bg-white transition duration-150">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Identity & Employment Information -->
                <div>
                    <div class="flex items-center mb-6 pb-2 border-b border-gray-100">
                        <div class="bg-indigo-100 p-2 rounded-lg mr-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Identity & Employment Details</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Aadhar -->
                        <div>
                            <label for="aadhar" class="block text-sm font-medium text-gray-700 mb-2">
                                Aadhar Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="aadhar" wire:model.live="aadhar"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="12-digit Aadhar number">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-regular fa-id-card text-sm"></i>
                                </div>
                            </div>
                            @error('aadhar') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- PAN -->
                        <div>
                            <label for="pan" class="block text-sm font-medium text-gray-700 mb-2">
                                PAN Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="pan" wire:model.live="pan"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 uppercase transition duration-150"
                                    placeholder="e.g. ABCDE1234F">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-credit-card text-sm"></i>
                                </div>
                            </div>
                            @error('pan') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Salary -->
                        <div>
                            <label for="salary" class="block text-sm font-medium text-gray-700 mb-2">
                                Salary (Monthly) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500 font-semibold text-sm">
                                    ₹
                                </div>
                                <input type="text" id="salary" wire:model.live="salary"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 pl-8 pr-3.5 transition duration-150"
                                    placeholder="e.g. 25000">
                            </div>
                            @error('salary') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea id="address" rows="3" wire:model.live="address"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 transition duration-150"
                                    placeholder="Street, City, State, Pincode"></textarea>
                            </div>
                            @error('address') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Inline Success Alert (Right above the buttons where user clicks) -->
                @if ($successMessage || session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <div class="p-1.5 rounded-full bg-emerald-100 text-emerald-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-emerald-900">Success!</h4>
                                <p class="text-sm text-emerald-700">{{ $successMessage ?: session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-800 p-1 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Form Actions Footer -->
                <div class="flex flex-col-reverse sm:flex-row justify-end items-center gap-3 pt-6 border-t border-gray-100">
                    <a wire:navigate href="{{ route('admin.receptionst.management') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 shadow-xs text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Cancel
                    </a>
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <span wire:loading.remove wire:target="update" class="flex items-center gap-2">
                            <i class="fa-solid fa-check"></i>
                            <span>Update Receptionist</span>
                        </span>
                        <span wire:loading wire:target="update" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Updating...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
