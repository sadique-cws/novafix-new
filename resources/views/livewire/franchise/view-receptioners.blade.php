<div class="container mx-auto  sm:px-6 lg:px-8 py-2 max-w-7xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Success Message -->
        @if (session('success'))
            <div class="p-4 bg-green-50 border-b border-green-200 flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Header Section -->
        <div
            class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Receptionist Details</h2>
                <p class="text-gray-500 mt-1">ID: {{ $receptionist->id }}</p>
            </div>
            <a wire:navigate href="{{ route('franchise.manage.receptioners') }}"
                class="inline-flex items-center px-4 py-2.5 sm:px-5 sm:py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back to List
            </a>
        </div>

        <!-- Main Content -->
        <div class="p-2 sm:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Personal Information Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Personal Information
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Full Name</div>
                            <div class="mt-1 text-lg font-semibold text-gray-900">{{ $receptionist->name }}</div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Email Address</div>
                            <div class="mt-1 text-lg text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                {{ $receptionist->email }}
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Contact Number</div>
                            <div class="mt-1 text-lg text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                {{ $receptionist->contact }}
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Aadhar Number</div>
                            <div class="mt-1 text-lg text-gray-800 tracking-wider font-mono">{{ $receptionist->aadhar }}
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">PAN Number</div>
                            <div class="mt-1 text-lg text-gray-800 uppercase tracking-wider font-mono">
                                {{ $receptionist->pan }}</div>
                        </div>
                    </div>
                </div>

                <!-- Employment Details Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                            </svg>
                            Employment Details
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Monthly Salary</div>
                            <div class="mt-1 text-2xl font-bold text-indigo-600">
                                ₹{{ number_format($receptionist->salary, 2) }}
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold leading-5 {{ $receptionist->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $receptionist->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Joined On</div>
                            <div class="mt-1 text-lg text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $receptionist->created_at->format('d M Y') }}
                                <span
                                    class="text-gray-500 ml-2 text-sm">({{ $receptionist->created_at->diffForHumans() }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Card (Full Width) -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden lg:col-span-2">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Address
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="prose prose-sm max-w-none text-gray-800">
                            {!! nl2br(e($receptionist->address)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button wire:click="confirmDelete({{ $receptionist->id }})" type="button"
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Delete
                </button>
                <button wire:click="$toggle('showEditModal')"
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Modal - Mobile Optimized -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ isScrolled: false }"
            @scroll.window="isScrolled = window.scrollY > 10">
            <!-- Background overlay with smoother transition -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity duration-300 ease-in-out"></div>

            <!-- Modal container with bottom-sheet behavior on mobile -->
            <div class="flex items-end justify-center min-h-screen pt-10 pb-20 px-4 text-center sm:block sm:p-0">
                <!-- Modal panel with dynamic height -->
                <div class="inline-block align-bottom bg-white rounded-t-3xl sm:rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full h-[85vh] max-h-screen"
                    :class="{ 'rounded-t-3xl': !isScrolled, 'rounded-t-xl': isScrolled }"
                    style="box-shadow: 0 -10px 25px -5px rgba(0, 0, 0, 0.1), 0 -5px 10px -5px rgba(0, 0, 0, 0.04)">

                    <!-- Modal header with sticky positioning -->
                    <div
                        class="sticky top-0 bg-white z-10 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">
                            Edit Receptionist
                        </h3>
                        <button wire:click="$toggle('showEditModal')"
                            class="p-2 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 focus:outline-none"
                            :disabled="$isUpdating">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Loading overlay with better visual hierarchy -->
                    @if ($isUpdating)
                        <div
                            class="absolute inset-0 bg-white bg-opacity-90 z-20 flex flex-col items-center justify-center p-6">
                            <div class="text-center">
                                <div class="relative w-16 h-16 mx-auto mb-4">
                                    <svg class="animate-spin h-full w-full text-indigo-600" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">Saving Changes</h4>
                                <p class="text-gray-600">Please wait while we update the details</p>
                                <div class="mt-4 w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-indigo-600 h-1.5 rounded-full animate-pulse" style="width: 65%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Modal content with better scrolling behavior -->
                    <div class="px-4 py-5 sm:p-6 overflow-y-auto h-[calc(100%-120px)]">
                        <form wire:submit.prevent="updateReceptionist">
                            <div class="space-y-5" :class="{ 'opacity-50': $isUpdating }">
                                <!-- Form grid with better mobile spacing -->
                                <div class="grid grid-cols-1 gap-5">
                                    <!-- Name Field -->
                                    <div class="space-y-2">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Full
                                            Name</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="text" wire:model="name" id="name"
                                                class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring-indigo-500 border"
                                                :disabled="$isUpdating" placeholder="Enter full name">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('name')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email Field -->
                                    <div class="space-y-2">
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="email" wire:model="email" id="email"
                                                class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring-indigo-500 border"
                                                :disabled="$isUpdating" placeholder="Enter email address">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('email')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Contact Field -->
                                    <div class="space-y-2">
                                        <label for="contact"
                                            class="block text-sm font-medium text-gray-700">Contact</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="tel" wire:model="contact" id="contact"
                                                class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring-indigo-500 border"
                                                :disabled="$isUpdating" placeholder="Enter phone number">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('contact')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Aadhar Field -->
                                    <div class="space-y-2">
                                        <label for="aadhar" class="block text-sm font-medium text-gray-700">Aadhar
                                            Number</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="text" wire:model="aadhar" id="aadhar"
                                                class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring-indigo-500 border"
                                                :disabled="$isUpdating" placeholder="Enter Aadhar number">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('aadhar')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- PAN Field -->
                                    <div class="space-y-2">
                                        <label for="pan" class="block text-sm font-medium text-gray-700">PAN
                                            Number</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="text" wire:model="pan" id="pan"
                                                class="block w-full rounded-lg border-gray-300 pl-4 pr-10 py-3 focus:border-indigo-500 focus:ring-indigo-500 border uppercase"
                                                :disabled="$isUpdating" placeholder="Enter PAN number">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('pan')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Salary Field -->
                                    <div class="space-y-2">
                                        <label for="salary"
                                            class="block text-sm font-medium text-gray-700">Salary</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">₹</span>
                                            </div>
                                            <input type="number" wire:model="salary" id="salary"
                                                class="block w-full pl-10 rounded-lg border-gray-300 py-3 focus:border-indigo-500 focus:ring-indigo-500 border"
                                                :disabled="$isUpdating" placeholder="Enter salary amount">
                                        </div>
                                        @error('salary')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status Field -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="mt-2 flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="status" value="1"
                                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                                    :disabled="$isUpdating">
                                                <span class="ml-2 text-gray-700">Active</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="status" value="0"
                                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                                    :disabled="$isUpdating">
                                                <span class="ml-2 text-gray-700">Inactive</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Address Field -->
                                    <div class="space-y-2">
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea wire:model="address" id="address" rows="3"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 border"
                                            :disabled="$isUpdating" placeholder="Enter full address"></textarea>
                                        @error('address')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Form actions with better mobile spacing -->
                                <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                    <button type="button" wire:click="$toggle('showEditModal')"
                                        class="w-full px-5 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                                        :disabled="$isUpdating">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="w-full px-5 py-3 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center transition-colors"
                                        :disabled="$isUpdating">
                                        @if ($isUpdating)
                                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Saving...
                                        @else
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Changes
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
