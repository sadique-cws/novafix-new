<div class="min-h-screen bg-gray-50 py-4 px-3 sm:px-6 lg:px-8">
    <x-slot name="navbar_back">
        <a wire:navigate href="{{ route('franchise.manage.staff') }}" class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Success Alert -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs animate-fade-in">
                <div class="flex items-center gap-2.5">
                    <div class="p-1.5 rounded-full bg-emerald-100 text-emerald-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-emerald-900">Success!</h4>
                        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-800 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Error Alert -->
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs animate-fade-in">
                <div class="flex items-center gap-2.5">
                    <div class="p-1.5 rounded-full bg-rose-100 text-rose-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-rose-900">Error</h4>
                        <p class="text-sm text-rose-700">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" @click="show = false" class="text-rose-500 hover:text-rose-800 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Info Alert -->
        @if(session('info'))
            <div x-data="{ show: true }" x-show="show" class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 flex items-center justify-between shadow-xs animate-fade-in">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('info') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-blue-500 hover:text-blue-800 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Gradient Header Banner -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-6 sm:px-8 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="h-14 w-14 rounded-full bg-white/10 backdrop-blur-sm border-2 border-white/20 flex items-center justify-center text-white font-bold text-xl overflow-hidden flex-shrink-0 shadow-inner">
                            @if($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover">
                            @elseif($staff->image)
                                <img src="{{ asset('storage/'.$staff->image) }}" alt="{{ $staff->name }}" class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr($name ?? 'S', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-2xl font-bold text-white">Edit Staff Member</h2>
                            </div>
                            <p class="text-blue-100 text-sm mt-0.5">Update technician details, professional category & credentials</p>
                        </div>
                    </div>
                    <div class="bg-white/15 text-white backdrop-blur-xs font-semibold px-3.5 py-1.5 rounded-full text-xs sm:text-sm border border-white/20 self-start sm:self-auto">
                        ID: #{{ $staff->id }}
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form wire:submit.prevent="updateStaff" class="p-6 sm:p-8 space-y-8">
                <!-- Section 1: Personal Information -->
                <div>
                    <div class="flex items-center mb-6 pb-2 border-b border-gray-100">
                        <div class="bg-blue-100 p-2 rounded-lg mr-3 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                            <p class="text-xs text-gray-500">Basic identity and contact information</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="name" wire:model="name"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="e.g. Rahul Sharma">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-regular fa-user text-sm"></i>
                                </div>
                            </div>
                            @error('name') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="email" id="email" wire:model="email"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="technician@example.com">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                            </div>
                            @error('email') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Contact / Phone -->
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="contact" wire:model="contact"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 transition duration-150"
                                    placeholder="+91 9876543210">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </div>
                            </div>
                            @error('contact') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
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
                                <input type="number" id="salary" wire:model="salary"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 pl-8 pr-3.5 transition duration-150"
                                    placeholder="e.g. 25000">
                            </div>
                            @error('salary') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Professional Information & Status -->
                <div>
                    <div class="flex items-center mb-6 pb-2 border-b border-gray-100">
                        <div class="bg-indigo-100 p-2 rounded-lg mr-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Professional Information</h3>
                            <p class="text-xs text-gray-500">Assigned domain category and employment status</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Service Category -->
                        <div>
                            <label for="service_categories_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Service Category <span class="text-red-500">*</span>
                            </label>
                            <select id="service_categories_id" wire:model="service_categories_id"
                                class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 bg-white transition duration-150">
                                <option value="">Select a category</option>
                                @foreach($serviceCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('service_categories_id') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status with custom cards -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Employment Status <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center p-3 rounded-lg border cursor-pointer transition-all {{ $status === 'active' ? 'border-emerald-500 bg-emerald-50/60 ring-2 ring-emerald-500/20' : 'border-gray-200 bg-white hover:bg-gray-50' }}">
                                    <input type="radio" wire:model="status" name="status" value="active" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                    <span class="ml-2.5 flex items-center gap-1.5 text-sm font-medium {{ $status === 'active' ? 'text-emerald-900' : 'text-gray-700' }}">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                </label>
                                <label class="flex items-center p-3 rounded-lg border cursor-pointer transition-all {{ $status === 'inactive' ? 'border-rose-500 bg-rose-50/60 ring-2 ring-rose-500/20' : 'border-gray-200 bg-white hover:bg-gray-50' }}">
                                    <input type="radio" wire:model="status" name="status" value="inactive" class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300">
                                    <span class="ml-2.5 flex items-center gap-1.5 text-sm font-medium {{ $status === 'inactive' ? 'text-rose-900' : 'text-gray-700' }}">
                                        <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                        Inactive
                                    </span>
                                </label>
                            </div>
                            @error('status') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Identification -->
                <div>
                    <div class="flex items-center mb-6 pb-2 border-b border-gray-100">
                        <div class="bg-amber-100 p-2 rounded-lg mr-3 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Identification Documents</h3>
                            <p class="text-xs text-gray-500">National identity numbers for verification</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Aadhar -->
                        <div>
                            <label for="aadhar" class="block text-sm font-medium text-gray-700 mb-2">
                                Aadhar Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="aadhar" wire:model="aadhar"
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
                                <input type="text" id="pan" wire:model="pan"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 pr-10 uppercase transition duration-150"
                                    placeholder="e.g. ABCDE1234F">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-credit-card text-sm"></i>
                                </div>
                            </div>
                            @error('pan') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Profile Image & Address -->
                <div>
                    <div class="flex items-center mb-6 pb-2 border-b border-gray-100">
                        <div class="bg-purple-100 p-2 rounded-lg mr-3 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Profile Image & Address</h3>
                            <p class="text-xs text-gray-500">Staff photograph and residential address</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Image Upload Area -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-4 rounded-xl border border-gray-200 bg-gray-50/50">
                                <!-- Thumbnail Preview -->
                                <div class="h-20 w-20 rounded-xl bg-white border border-gray-200 overflow-hidden flex-shrink-0 flex items-center justify-center shadow-xs">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" alt="New preview" class="h-full w-full object-cover">
                                    @elseif($staff->image)
                                        <img src="{{ asset('storage/'.$staff->image) }}" alt="Current photo" class="h-full w-full object-cover">
                                    @else
                                        <i class="fa-regular fa-user text-3xl text-gray-300"></i>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-1.5">
                                    <div class="flex items-center gap-3">
                                        <label for="image" class="cursor-pointer inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 rounded-lg text-xs font-semibold shadow-xs transition">
                                            <i class="fa-solid fa-cloud-arrow-up text-blue-600"></i>
                                            <span>{{ $image ? 'Change Selected File' : ($staff->image ? 'Replace Photo' : 'Upload Photo') }}</span>
                                            <input id="image" name="image" type="file" wire:model="image" class="sr-only">
                                        </label>
                                        @if($image)
                                            <button type="button" wire:click="$set('image', null)" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                                Remove Selection
                                            </button>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">Supports JPG, PNG or WebP up to 2MB</p>
                                    <div wire:loading wire:target="image" class="text-xs text-blue-600 font-medium flex items-center gap-1.5">
                                        <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading preview...
                                    </div>
                                    @error('image') <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea wire:model="address" id="address" rows="3"
                                    class="block w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3.5 transition duration-150"
                                    placeholder="Street, Area, City, State, PIN"></textarea>
                            </div>
                            @error('address') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions Footer -->
                <div class="flex flex-col-reverse sm:flex-row justify-end items-center gap-3 pt-6 border-t border-gray-100">
                    <button type="button" wire:click="resetForm"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 shadow-xs text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Reset Form
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <span wire:loading.remove wire:target="updateStaff" class="flex items-center gap-2">
                            <i class="fa-solid fa-check"></i>
                            <span>Update Staff</span>
                        </span>
                        <span wire:loading wire:target="updateStaff" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Saving Changes...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
