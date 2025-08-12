<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white mr-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h2 class="text-xl font-bold text-white">Edit Service Request</h2>
                </div>
                <div class="text-sm text-blue-100">
                    Request ID: {{ $serviceRequest->service_code }}
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="p-2 py-8">
            <form wire:submit.prevent="update">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Customer Information -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Customer Information
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="owner_name" class="block text-sm font-medium text-gray-700">Full
                                        Name</label>
                                    <input type="text" wire:model="owner_name" id="owner_name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('owner_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" wire:model="email" id="email"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('email')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact" class="block text-sm font-medium text-gray-700">Phone
                                        Number</label>
                                    <input type="text" wire:model="contact" id="contact"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('contact')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Product Information
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product
                                        Name</label>
                                    <input type="text" wire:model="product_name" id="product_name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('product_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                                    <input type="text" wire:model="brand" id="brand"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('brand')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="serial_no" class="block text-sm font-medium text-gray-700">Serial
                                            No.</label>
                                        <input type="text" wire:model="serial_no" id="serial_no"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @error('serial_no')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="color"
                                            class="block text-sm font-medium text-gray-700">Color</label>
                                        <input type="text" wire:model="color" id="color"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @error('color')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="MAC" class="block text-sm font-medium text-gray-700">MAC Address
                                        (if applicable)</label>
                                    <input type="text" wire:model="MAC" id="MAC"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('MAC')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Service Details -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Service Details
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="service_categories_id"
                                        class="block text-sm font-medium text-gray-700">Service Category</label>
                                    <select wire:model="service_categories_id" id="service_categories_id"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_categories_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="technician_id"
                                        class="block text-sm font-medium text-gray-700">Assigned Technician</label>
                                    <select wire:model="technician_id" id="technician_id"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Unassigned</option>
                                        @foreach ($technicians as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('technician_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="problem" class="block text-sm font-medium text-gray-700">Problem
                                        Description</label>
                                    <textarea wire:model="problem" id="problem" rows="3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    @error('problem')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="service_amount"
                                        class="block text-sm font-medium text-gray-700">Service Fee</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₹</span>
                                        </div>
                                        <input type="number" wire:model="service_amount" id="service_amount"
                                            class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md py-2 px-3"
                                            placeholder="0.00">
                                    </div>
                                    @error('service_amount')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status & Delivery -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Status & Delivery
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="status" id="status"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="0">Pending</option>
                                        <option value="50">In Progress</option>
                                        <option value="100">Completed</option>
                                        <option value="-1">Rejected</option>
                                    </select>
                                    @error('status')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="estimate_delivery"
                                        class="block text-sm font-medium text-gray-700">Estimated Delivery</label>
                                    <input type="datetime-local" wire:model="estimate_delivery"
                                        id="estimate_delivery"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('estimate_delivery')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_delivery"
                                        class="block text-sm font-medium text-gray-700">Actual Delivery (if
                                        completed)</label>
                                    <input type="datetime-local" wire:model="date_of_delivery" id="date_of_delivery"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('date_of_delivery')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Product Image
                            </h3>

                            <div class="space-y-4">
                                <!-- Current Image (only shown if no new image selected) -->
                                @if ($existingImage && !$image && !$capturedImage)
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Current Image</p>
                                        <img src="{{ asset('storage/' . $existingImage) }}" alt="Product Image"
                                            class="h-32 rounded-lg object-cover border border-gray-200">
                                    </div>
                                @endif

                                <!-- New Image Preview -->
                                @if ($image)
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">New Image</p>
                                        <img src="{{ $image->temporaryUrl() }}" alt="Uploaded Image Preview"
                                            class="h-32 rounded-lg object-cover border border-gray-200">
                                    </div>
                                @endif

                                <!-- Captured Image Preview -->
                                @if ($capturedImage)
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Captured Image</p>
                                        <img src="{{ $capturedImage }}" alt="Captured Image Preview"
                                            class="h-32 rounded-lg object-cover border border-gray-200">
                                    </div>
                                @endif

                                <!-- Image Upload Options -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- File Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload New
                                            Image</label>
                                        <div class="mt-1 flex items-center">
                                            <input type="file" wire:model="image" id="image" class="sr-only">
                                            <label for="image"
                                                class="w-full cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                                                Select File
                                            </label>
                                        </div>
                                        @error('image')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                  
                                </div>

                                @if ($existingImage || $image || $capturedImage)
                                    <div class="pt-2">
                                        <button type="button" wire:click="removeImage"
                                            class="text-sm bg-red-600 text-white p-2 rounded hover:text-red-800 focus:outline-none">
                                            Remove Image
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                <a href="{{ route('frontdesk.servicerequest.manage') }}"
                    class="mt-3 sm:mt-0 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    wire:loading.attr="disabled">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Update Service Request</span>
                    <span wire:loading>
                        <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
            </form>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg text-sm flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg text-sm flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            // Initialize camera when the camera section is shown
            document.addEventListener('livewire:init', () => {
                Livewire.on('startCamera', () => {
                    initCamera();
                });
            });

            function initCamera() {
                const cameraFeed = document.getElementById('camera-feed');
                let stream = null;

                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    Livewire.emit('cameraError', 'Camera API not supported in this browser');
                    return;
                }

                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(s) {
                        stream = s;
                        cameraFeed.innerHTML =
                            '<video class="w-full h-full object-cover" autoplay playsinline></video>';
                        const video = cameraFeed.querySelector('video');
                        video.srcObject = stream;
                    })
                    .catch(function(err) {
                        Livewire.emit('cameraError', 'Could not access camera: ' + err.message);
                    });

                // Clean up when the component is destroyed
                Livewire.on('stopCamera', () => {
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                });
            }

            function captureImage() {
                const cameraFeed = document.getElementById('camera-feed');
                const video = cameraFeed.querySelector('video');

                if (!video) {
                    Livewire.emit('cameraError', 'Camera not initialized');
                    return;
                }

                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = canvas.toDataURL('image/jpeg');
                Livewire.emit('imageCaptured', imageData);
            }

            window.captureImage = captureImage;
        });
    </script>
@endpush
