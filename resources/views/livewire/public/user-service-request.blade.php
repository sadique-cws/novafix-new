<div class="min-h-screen  bg-gray-50 py-10 px-4">
    @if (!$submitted)
        <div class="max-w-4xl mx-auto bg-white rounded border border-gray-400 p-8">
            <h2 class="text-2xl text-center  text-green-600 font-semibold underline mb-6 border-b pb-3">
                Service Request Form
            </h2>

            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data">

                {{-- Franchise --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Franchise *</label>
                    <select wire:model="franchise_id"
                            class="w-full rounded-lg border py-1 px-2 border-gray-500">
                        <option value="">Select Franchise</option>
                        @foreach($franchises as $franchise)
                            <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
                        @endforeach
                    </select>
                    @error('franchise_id') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Service Category --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Service Category *</label>
                    <select wire:model="service_categories_id"
                            class="w-full rounded-lg  border py-1 px-2 border-gray-500">
                        <option value="">Select Category</option>
                        @foreach($serviceCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('service_categories_id') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Owner Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Owner Name *</label>
                        <input type="text" wire:model="owner_name"
                               class="w-full rounded-lg  border py-1 px-2 border-gray-500">
                        @error('owner_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email (optional)</label>
                        <input type="email" wire:model="email"
                               class="w-full rounded-lg  border py-1 px-2 border-gray-500">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Contact --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Contact *</label>
                    <input type="text" wire:model="contact"
                           class="w-full rounded-lg  border py-1 px-2 border-gray-500">
                    @error('contact') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Product Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                        <input type="text" wire:model="product_name"
                               class="w-full rounded-lg border py-1 px-2 border-gray-500">
                        @error('product_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Brand *</label>
                        <input type="text" wire:model="brand"
                               class="w-full rounded-lg  border py-1 px-2 border-gray-500">
                        @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Color *</label>
                    <input type="text" wire:model="color"
                           class="w-full rounded-lg  border py-1 px-2 border-gray-500">
                    @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Problem --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Problem Description *</label>
                    <textarea wire:model="problem" rows="4"
                              class="w-full rounded-lg  border py-1 px-2 border-gray-500"></textarea>
                    @error('problem') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Image (optional)</label>
                    
                    <input type="file" wire:model="image" id="image"
                           class="w-full text-sm text-gray-600 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                  file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('image') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                    
                    <!-- Upload Progress -->
                    @if($uploadProgress > 0 && $uploadProgress < 100)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Uploading image: {{ $uploadProgress }}%</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $uploadProgress }}%"></div>
                            </div>
                        </div>
                    @endif
                    
                    @if ($image)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Image Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" alt="Image preview" class="mt-2 rounded-lg shadow-md max-w-full h-auto max-h-64">
                        </div>
                    @endif
                    
                    @if($imagekit_url)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Uploaded Image:</p>
                            <img src="{{ $imagekit_url }}" alt="Uploaded image" class="mt-2 rounded-lg shadow-md max-w-full h-auto max-h-64">
                            <button type="button" wire:click="removeImage" class="mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm">
                                Remove Image
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit" wire:loading.attr="disabled"
                            class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition-colors duration-200
                                   disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                        <span wire:loading>
                            <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span wire:loading.remove>Submit Request</span>
                    </button>
                </div>
            </form>
        </div>
   @else
        <!-- Success Page -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8 text-center">
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
                    <span id="service-code" class="text-2xl font-bold text-indigo-700 font-mono">{{ $serviceCode }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Please note it down anywhere! It may be asked while reviewing your product.</p>
            </div>

            <!-- Copy Code Button -->
            <div class="mb-8">
                <button id="copy-button" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center justify-center mx-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copy Code
                </button>
            </div>

            <!-- Additional Options -->
            <div class="border-t pt-6">
                <p class="text-gray-600 mb-4">What would you like to do next?</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('track.service') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Track Your Service
                    </a>
                    <button wire:click="$set('submitted', false)" 
                            class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors duration-200">
                        Submit Another Request
                    </button>
                </div>
            </div>
        </div>

        <!-- Improved Copy to Clipboard Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const copyButton = document.getElementById('copy-button');
                const serviceCode = document.getElementById('service-code').textContent;
                
                copyButton.addEventListener('click', function() {
                    navigator.clipboard.writeText(serviceCode).then(function() {
                        // Show success message
                        const originalText = copyButton.innerHTML;
                        
                        copyButton.innerHTML = `
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Copied!
                        `;
                        
                        copyButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                        copyButton.classList.add('bg-green-600', 'hover:bg-green-700');
                        
                        setTimeout(function() {
                            copyButton.innerHTML = originalText;
                            copyButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                            copyButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                        }, 2000);
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                        
                        // Fallback method for browsers that don't support clipboard API
                        const textArea = document.createElement('textarea');
                        textArea.value = serviceCode;
                        textArea.style.position = 'fixed';
                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();
                        
                        try {
                            const successful = document.execCommand('copy');
                            if (successful) {
                                // Show success message even with fallback
                                const originalText = copyButton.innerHTML;
                                copyButton.innerHTML = `
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Copied!
                                `;
                                copyButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                                copyButton.classList.add('bg-green-600', 'hover:bg-green-700');
                                
                                setTimeout(function() {
                                    copyButton.innerHTML = originalText;
                                    copyButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                                    copyButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                                }, 2000);
                            } else {
                                alert('Failed to copy code. Please copy it manually: ' + serviceCode);
                            }
                        } catch (fallbackErr) {
                            alert('Failed to copy code. Please copy it manually: ' + serviceCode);
                        }
                        
                        document.body.removeChild(textArea);
                    });
                });
            });
        </script>
    @endif
</div>