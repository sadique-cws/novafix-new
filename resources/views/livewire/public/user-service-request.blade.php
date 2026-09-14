<div class="min-h-screen bg-gray-50 py-10 px-4" x-data="{ copied: false }">
    @if (!$submitted)
        <div class="max-w-4xl mx-auto bg-white rounded-lg border border-gray-200 p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Service Request Form</h2>
                <p class="text-gray-500">Please fill out the details below to request a repair.</p>
            </div>
            <hr class="mb-8 border-gray-100"> 
            
            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('info'))
                <div class="mb-6 p-4 bg-blue-100 text-blue-700 rounded-lg">
                    {{ session('info') }}
                </div>
            @endif

            @if ($isExistingCustomer)
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-semibold">Welcome back!</span>
                    </div>
                    <p class="mt-1 text-sm">We found your previous service requests. Your details have been auto-filled.</p>
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Contact --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                        <input type="text" wire:model.live="contact"
                               class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                               placeholder="Enter 10-digit mobile number">
                        @error('contact') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Franchise --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Franchise *</label>
                        <select wire:model="franchise_id"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition bg-white">
                            <option value="">Choose a location...</option>
                            @foreach($franchises as $franchise)
                                <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
                            @endforeach
                        </select>
                        @error('franchise_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Owner Info --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Owner Name *</label>
                        <input type="text" wire:model="owner_name"
                               class="w-full rounded-md border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition {{ $isExistingCustomer ? 'bg-green-50 border-green-300 text-green-800' : 'border-gray-300' }}"
                               placeholder="Your full name">
                        @error('owner_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address (Optional)</label>
                        <input type="email" wire:model="email"
                               class="w-full rounded-md border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition {{ $isExistingCustomer ? 'bg-green-50 border-green-300 text-green-800' : 'border-gray-300' }}"
                               placeholder="you@example.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr class="border-gray-100 my-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Device Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Service Category --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Device Type *</label>
                        <select wire:model="service_categories_id"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition bg-white">
                            <option value="">Select device type...</option>
                            @foreach($serviceCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('service_categories_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Product Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model / Product Name *</label>
                        <input type="text" wire:model="product_name"
                               class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                               placeholder="e.g. iPhone 13 Pro, Dell XPS 15">
                        @error('product_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Brand --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                        <input type="text" wire:model="brand"
                               class="w-full rounded-md border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition {{ $isExistingCustomer ? 'bg-green-50 border-green-300 text-green-800' : 'border-gray-300' }}"
                               placeholder="e.g. Apple, Samsung, Dell">
                        @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Color --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Color *</label>
                        <input type="text" wire:model="color"
                               class="w-full rounded-md border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition {{ $isExistingCustomer ? 'bg-green-50 border-green-300 text-green-800' : 'border-gray-300' }}"
                               placeholder="e.g. Space Gray, Black">
                        @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Problem --}}
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Problem Description *</label>
                    <textarea wire:model="problem" rows="4"
                              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none"
                              placeholder="Please describe the issue you are facing with your device in detail..."></textarea>
                    @error('problem') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Image Upload (Drag & Drop) --}}
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Device Image (Optional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary hover:bg-gray-50 transition-colors cursor-pointer relative"
                         x-data="{ isUploading: false, progress: 0 }"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress">
                        
                        <input type="file" wire:model="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                        
                        <div class="space-y-1 text-center relative z-0">
                            @if ($image)
                                <div class="mb-4 flex justify-center">
                                    <img src="{{ $image->temporaryUrl() }}" class="h-40 object-contain rounded-md shadow-sm border border-gray-200">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="text-primary font-semibold hover:underline">Change image</span> or drag and drop another
                                </div>
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative font-semibold text-primary hover:text-blue-800">
                                        Click to upload
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 5MB</p>
                            @endif
                            
                            <!-- Upload Progress -->
                            <div x-show="isUploading" class="w-full mt-4 max-w-xs mx-auto">
                                <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-primary h-2 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-center" x-text="`Uploading: ${progress}%`"></p>
                            </div>
                        </div>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Submit --}}
                <div class="pt-6 mt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" wire:loading.attr="disabled"
                            class="px-8 py-3 bg-primary text-white font-semibold rounded-lg shadow-md hover:bg-blue-800 
                                   focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200
                                   disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center min-w-[200px]">
                        <span wire:loading class="mr-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </span>
                        <span wire:loading.remove class="mr-2">
                            <i class="fas fa-paper-plane"></i>
                        </span>
                        <span>
                            @if($isExistingCustomer)
                                Submit New Request
                            @else
                                Submit Request
                            @endif
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- Success Page (same as before) -->
       
        
        <!-- Success Page -->
        <div class="max-w-2xl mx-auto bg-white rounded-lg border border-gray-200 p-8 text-center">
            <!-- Logo/Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-indigo-600">NovaFix</h1>
                <p class="text-gray-600">Professional Device Repair Services</p>
            </div>

            <!-- Success Icon -->
            <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Success Message -->
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Request submitted successfully!</h2>
            
            <div class="text-gray-600 mb-8">
                <p class="mb-2">Dear <strong>{{ $owner_name }}</strong> your request has been submitted successfully!</p>
                <p>Wait for our staff to review your request. We will try our best to start work on your requested issue as soon as possible...</p>
            </div>

            <!-- Service Code -->
            <div class="mb-8">
                <p class="text-gray-700 mb-2">Here is your service code</p>
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 inline-block">
                    <span id="service-code" class="text-2xl  text-indigo-700 font-serif">{{ $serviceCode }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Please note it down anywhere! It may be asked while reviewing your product.</p>
            </div>

            <!-- Copy Code Button -->
            <div class="mb-8">
                <button @click="navigator.clipboard.writeText('{{ $serviceCode }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                        class="px-6 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center mx-auto"
                        :class="copied ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-indigo-600 hover:bg-indigo-700 text-white'">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              :d="copied ? 'M5 13l4 4L19 7' : 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z'"></path>
                    </svg>
                    <span x-text="copied ? 'Copied!' : 'Copy Code'"></span>
                </button>
            </div>
            <!-- Additional Options -->
            <div class="border-t pt-6">
                <p class="text-gray-600 mb-4">What would you like to do next?</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('track.service') }}" 
                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                        Track Your Service
                    </a>
                    <button wire:click="$set('submitted', false)" 
                            class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-200">
                        Submit Another Request
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>