<div>
    <main class="flex-1 p-2 md:p-6 bg-gray-100 min-h-screen font-poppins">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-3xl font-semibold text-slate-700 mb-6">New Service Request</h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Service Category Dropdown -->
                    <div>
                        <label for="service_categories_id" class="block text-sm font-medium text-slate-600">Service
                            Category
                            *</label>
                        <select id="service_categories_id" wire:model="service_categories_id"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                            <option value="">Select Service Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('service_categories_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Technician Dropdown -->
                    <div>
                        <label for="technician_id" class="block text-sm font-medium text-slate-600">Technician</label>
                        <select id="technician_id" wire:model="technician_id"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                            <option value="">Select Technician</option>
                            @foreach ($technicians as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                            @endforeach
                        </select>
                        @error('technician_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Code -->
                    <div>
                        <label for="service_code" class="block text-sm font-medium text-slate-600">Service Code</label>
                        <div class="mt-1 w-full rounded-md border border-slate-300 shadow-sm bg-gray-50 p-2">
                            {{ $service_code }}
                        </div>
                        <input type="hidden" wire:model="service_code">
                    </div>

                    <!-- Owner Name -->
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-slate-600">Owner Name *</label>
                        <input type="text" id="owner_name" wire:model="owner_name"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('owner_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-slate-600">Product Name
                            *</label>
                        <input type="text" id="product_name" wire:model="product_name"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('product_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-600">Email</label>
                        <input type="email" id="email" wire:model="email"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Contact -->
                    <div>
                        <label for="contact" class="block text-sm font-medium text-slate-600">Contact *</label>
                        <input type="tel" id="contact" wire:model="contact"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('contact')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-slate-600">Brand *</label>
                        <input type="text" id="brand" wire:model="brand"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('brand')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Serial No -->
                    <div>
                        <label for="serial_no" class="block text-sm font-medium text-slate-600">Serial No</label>
                        <input type="text" id="serial_no" wire:model="serial_no"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('serial_no')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- MAC Address -->
                    <div>
                        <label for="MAC" class="block text-sm font-medium text-slate-600">MAC Address</label>
                        <input type="text" id="MAC" wire:model="MAC"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('MAC')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-slate-600">Color *</label>
                        <input type="text" id="color" wire:model="color"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('color')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Amount -->
                    <div>
                        <label for="service_amount" class="block text-sm font-medium text-slate-600">Service
                            Amount</label>
                        <input type="number" step="0.01" id="service_amount" wire:model="service_amount"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('service_amount')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-600">Product Image</label>

                        <div x-data="{
                            showCamera: false,
                            showDesktopCamera: false,
                            capturedImage: null,
                            stream: null,
                            error: null,
                            isLoading: false,
                            isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
                        
                            async startMobileCamera() {
                                this.error = null;
                                @this.set('cameraError', null);
                                this.isLoading = true;
                        
                                try {
                                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                                        throw new Error('Camera not supported in your browser');
                                    }
                        
                                    // Request HTTPS for mobile if not localhost
                                    if (this.isMobile && window.location.protocol !== 'https:' && !window.location.hostname.includes('localhost')) {
                                        throw new Error('Camera requires HTTPS on mobile devices');
                                    }
                        
                                    this.showCamera = true;
                                    await this.$nextTick();
                        
                                    const constraints = {
                                        video: {
                                            facingMode: 'environment',
                                            width: { ideal: 1280 },
                                            height: { ideal: 720 }
                                        },
                                        audio: false
                                    };
                        
                                    // iOS specific handling
                                    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                                        constraints.video = {
                                            facingMode: 'environment',
                                            width: { exact: 1280 },
                                            height: { exact: 720 }
                                        };
                                    }
                        
                                    this.stream = await navigator.mediaDevices.getUserMedia(constraints)
                                        .catch(err => {
                                            if (err.name === 'NotAllowedError') {
                                                throw new Error('Please allow camera access in your browser settings');
                                            }
                                            throw err;
                                        });
                        
                                    this.$refs.video.srcObject = this.stream;
                        
                                    // iOS specific handling
                                    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                                        this.$refs.video.playsInline = true;
                                        this.$refs.video.muted = true;
                                        await this.$refs.video.play();
                                    }
                                } catch (err) {
                                    console.error('Camera error:', err);
                                    this.error = err.message;
                                    @this.set('cameraError', err.message);
                                    this.showCamera = false;
                                    this.stopCamera();
                                } finally {
                                    this.isLoading = false;
                                }
                            },
                        
                            async startDesktopCamera() {
                                this.error = null;
                                @this.set('cameraError', null);
                                this.isLoading = true;
                        
                                try {
                                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                                        throw new Error('Camera not supported in your browser');
                                    }
                        
                                    this.showDesktopCamera = true;
                                    await this.$nextTick();
                        
                                    const constraints = {
                                        video: {
                                            width: { ideal: 1280 },
                                            height: { ideal: 720 }
                                        },
                                        audio: false
                                    };
                        
                                    this.stream = await navigator.mediaDevices.getUserMedia(constraints)
                                        .catch(err => {
                                            if (err.name === 'NotAllowedError') {
                                                throw new Error('Please allow camera access in your browser settings');
                                            }
                                            throw err;
                                        });
                        
                                    this.$refs.desktopVideo.srcObject = this.stream;
                                } catch (err) {
                                    console.error('Camera error:', err);
                                    this.error = err.message;
                                    @this.set('cameraError', err.message);
                                    this.showDesktopCamera = false;
                                    this.stopCamera();
                                } finally {
                                    this.isLoading = false;
                                }
                            },
                        
                            stopCamera() {
                                if (this.stream) {
                                    this.stream.getTracks().forEach(track => track.stop());
                                    this.stream = null;
                                }
                            },
                        
                            captureImage() {
                                this.isLoading = true;
                                try {
                                    const video = this.showCamera ? this.$refs.video : this.$refs.desktopVideo;
                                    if (!video || !video.videoWidth) {
                                        throw new Error('Camera not ready');
                                    }
                        
                                    const canvas = document.createElement('canvas');
                                    canvas.width = video.videoWidth;
                                    canvas.height = video.videoHeight;
                                    const ctx = canvas.getContext('2d');
                                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        
                                    this.capturedImage = canvas.toDataURL('image/jpeg');
                                    @this.set('capturedImage', this.capturedImage);
                                    @this.set('image', null);
                        
                                    this.stopCamera();
                                    this.showCamera = false;
                                    this.showDesktopCamera = false;
                                } catch (err) {
                                    console.error('Capture error:', err);
                                    this.error = 'Failed to capture image: ' + err.message;
                                    @this.set('cameraError', 'Failed to capture image');
                                } finally {
                                    this.isLoading = false;
                                }
                            },
                        
                            retakeImage() {
                                this.capturedImage = null;
                                @this.set('capturedImage', null);
                                if (this.isMobile) {
                                    this.startMobileCamera();
                                } else {
                                    this.startDesktopCamera();
                                }
                            },
                        
                            uploadImage() {
                                this.capturedImage = null;
                                @this.set('capturedImage', null);
                            },
                        
                            handleFileUpload() {
                                this.isLoading = true;
                                // Livewire will handle the upload and isLoading will be reset when done
                            }
                        }" x-init="$watch('showCamera', value => { if (!value) { stopCamera(); } });
                        $watch('showDesktopCamera', value => { if (!value) { stopCamera(); } });">

                            <!-- Loader -->
                            <div x-show="isLoading" x-transition.opacity
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
                                <div class="text-center">
                                    <div class="spinner">
                                        <div class="double-bounce1 bg-red-600"></div>
                                        <div class="double-bounce2 bg-indigo-600"></div>
                                    </div>
                                    <p class="mt-4 text-white font-medium">Processing image...</p>
                                </div>
                            </div>

                            <!-- Mobile Camera Preview Modal -->
                            <div x-show="showCamera" x-transition
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
                                <div class="bg-white rounded-lg p-4 max-w-md w-full">
                                    <div class="relative">
                                        <video x-ref="video" autoplay playsinline
                                            class="w-full h-auto rounded-lg"></video>
                                        <div class="absolute bottom-4 left-0 right-0 flex justify-center">
                                            <button @click="captureImage" class="bg-white rounded-full p-3 shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <button @click="showCamera = false; stopCamera();"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-md">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop Camera Preview Modal -->
                            <div x-show="showDesktopCamera" x-transition
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
                                <div class="bg-white rounded-lg p-4 max-w-2xl w-full">
                                    <h3 class="text-lg font-medium mb-4">Web Camera</h3>
                                    <div class="relative">
                                        <video x-ref="desktopVideo" autoplay playsinline
                                            class="w-full h-auto rounded-lg"></video>
                                        <div class="absolute bottom-4 left-0 right-0 flex justify-center">
                                            <button @click="captureImage" class="bg-white rounded-full p-3 shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <button @click="showDesktopCamera = false; stopCamera();"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-md">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Camera Capture Buttons -->
                            <div class="mt-2 flex flex-wrap gap-2">
                                <!-- Mobile Camera Button (only shown on mobile) -->
                                <template x-if="isMobile">
                                    <label :disabled="isLoading"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                        <input type="file" id="image" wire:model="image" accept="image/*"
                                            capture="environment" class="hidden"
                                            @change="isLoading = true; $nextTick(() => { $wire.upload('image', $event.target.files[0], () => { isLoading = false }, () => { isLoading = false }) })">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Use Mobile Camera
                                    </label>
                                </template>

                                <!-- Desktop Camera Button (only shown on desktop) -->
                                <template x-if="!isMobile">
                                    <button type="button" @click="startDesktopCamera" :disabled="isLoading"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Use Web Camera
                                    </button>
                                </template>

                                <!-- File Upload Option -->
                                <label
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="isLoading">
                                    <input type="file" id="image" wire:model="image" accept="image/*"
                                        class="hidden"
                                        @change="isLoading = true; $nextTick(() => { $wire.upload('image', $event.target.files[0], () => { isLoading = false }, () => { isLoading = false }) })">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Upload File
                                </label>
                            </div>
 
                            <!-- Image Previews -->
                            <div class="mt-4 space-y-4">
                                <!-- Camera Capture Preview -->
                                <template x-if="capturedImage">
                                    <div class="relative flex flex-col items-center">
                                        <img :src="capturedImage" alt="Captured photo"
                                            class="w-[120px] md:w-auto md:max-w-xs rounded-md shadow-sm">
                                        <div class="mt-2 flex gap-2 justify-center">
                                            <button @click="retakeImage" type="button"
                                                class="px-3 py-1 bg-gray-500 text-white rounded-md text-sm">
                                                Retake
                                            </button>
                                            <button @click="uploadImage" type="button"
                                                class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm">
                                                Use This Image
                                            </button>
                                        </div>
                                    </div>
                                </template>

                                <!-- File Upload Preview -->
                                @if ($image)
                                    <div class="relative flex flex-col items-center">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Uploaded photo"
                                            class="w-[120px] md:w-auto md:max-w-xs rounded-md shadow-sm">
                                        <button wire:click="removeImage" type="button"
                                            class="mt-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm">
                                            Remove
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- Error Messages -->
                            <div x-show="error" class="mt-2 p-2 bg-red-100 text-red-700 rounded">
                                <span x-text="error"></span>
                            </div>
                            @error('cameraError')
                                <div class="mt-2 p-2 bg-red-100 text-red-700 rounded">
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('image')
                                <div class="mt-2 p-2 bg-red-100 text-red-700 rounded">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Problem Description -->
                    <div class="md:col-span-2">
                        <label for="problem" class="block text-sm font-medium text-slate-600">Problem Description
                            *</label>
                        <textarea id="problem" wire:model="problem" rows="3"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2"></textarea>
                        @error('problem')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Estimate Delivery -->
                    <div>
                        <label for="estimate_delivery" class="block text-sm font-medium text-slate-600">Estimated
                            Delivery
                            *</label>
                        <input type="datetime-local" id="estimate_delivery" wire:model="estimate_delivery"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('estimate_delivery')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date of Delivery -->
                    <div>
                        <label for="date_of_delivery" class="block text-sm font-medium text-slate-600">Date of
                            Delivery</label>
                        <input type="datetime-local" id="date_of_delivery" wire:model="date_of_delivery"
                            class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        @error('date_of_delivery')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </main>
    <style>
        .spinner {
            width: 60px;
            height: 60px;
            position: relative;
            margin: 0 auto;
        }

        .double-bounce1,
        .double-bounce2 {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            opacity: 0.6;
            position: absolute;
            top: 0;
            left: 0;
            animation: sk-bounce 2.0s infinite ease-in-out;
        }

        .double-bounce2 {
            animation-delay: -1.0s;
        }

        @keyframes sk-bounce {

            0%,
            100% {
                transform: scale(0.0);
            }

            50% {
                transform: scale(1.0);
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                // Reset loading state when Livewire finishes processing
                Livewire.hook('message.processed', (message, component) => {
                    if (message.updateQueue[0]?.payload.name === 'image') {
                        const alpineComponent = document.querySelector('[x-data]').__x.$data;
                        if (alpineComponent) {
                            alpineComponent.isLoading = false;
                        }
                    }
                });
            });

            // Optional: If you need to handle the previewImage function
            function previewImage(input) {
                const alpineComponent = document.querySelector('[x-data]').__x.$data;
                if (input.files && input.files[0]) {
                    alpineComponent.isLoading = true;
                    // Your preview logic here if needed
                }
            }
        </script>
    @endpush
</div>
