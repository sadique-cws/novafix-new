<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">
                Track Your Service Request
            </h2>

            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="track" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Service Code</label>
                    <div class="flex space-x-2">
                        <input type="text" wire:model="service_code" placeholder="Enter your service code (e.g., SO3l9s-00001)"
                               class="flex-1 rounded-lg border-gray-500 px-2 border">
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Track
                        </button>
                    </div>
                    @error('service_code') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
            </form>
        </div>

        @if ($serviceRequest)
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Service Request Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Basic Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Basic Information</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Service Code:</span>
                                <p class="font-mono text-indigo-600">{{ $serviceRequest->service_code }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Owner Name:</span>
                                <p>{{ $serviceRequest->owner_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Product:</span>
                                <p>{{ $serviceRequest->product_name }} ({{ $serviceRequest->brand }})</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Contact:</span>
                                <p>{{ $serviceRequest->contact }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Status Information</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Current Status:</span>
                                <p class="text-lg font-semibold 
                                    @if($serviceRequest->status == -1) text-red-600 
                                    @elseif($serviceRequest->status == 0) text-blue-600 
                                    @elseif($serviceRequest->status == 1.0) text-green-600 
                                    @elseif($serviceRequest->status == 2.0) text-purple-600 
                                    @else text-gray-600 @endif">
                                    @if($serviceRequest->status == 90)
                                        Cancelled
                                    @elseif($serviceRequest->status == 0)
                                        In Progress
                                    @elseif($serviceRequest->status == 100)
                                        Completed
                                    @elseif($serviceRequest->status == 2)
                                        Delivered
                                    @else
                                        Unknown
                                    @endif
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Category:</span>
                                <p>{{ $serviceRequest->category->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Franchise:</span>
                                <p>{{ $serviceRequest->franchise->franchise_name }}</p>
                            </div>
                            @if($serviceRequest->technician)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Technician:</span>
                                <p>{{ $serviceRequest->technician->name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Problem Description -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Problem Description</h4>
                    <p class="text-gray-800">{{ $serviceRequest->problem }}</p>
                </div>

                <!-- Timeline -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Service Timeline</h4>
                    <div class="relative">
                        <!-- Timeline -->
                        <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>
                        
                        <ul class="space-y-4">
                            <!-- Request Received -->
                            <li class="relative pl-10">
                                <div class="absolute left-0 top-0 h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <p class="font-medium text-gray-900">Request Received</p>
                                    <p class="text-sm text-gray-500">{{ $serviceRequest->created_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Your service request has been registered</p>
                            </li>

                            <!-- In Progress -->
                            @if($serviceRequest->status >= 0)
                            <li class="relative pl-10">
                                <div class="absolute left-0 top-0 h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <p class="font-medium text-gray-900">In Progress</p>
                                    <p class="text-sm text-gray-500">{{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Your product is being serviced</p>
                            </li>
                            @endif

                            <!-- Completed -->
                            @if($serviceRequest->status >= 1.0)
                            <li class="relative pl-10">
                                <div class="absolute left-0 top-0 h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <p class="font-medium text-gray-900">Completed</p>
                                    <p class="text-sm text-gray-500">{{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Service has been completed</p>
                            </li>
                            @endif

                            <!-- Delivered -->
                            @if($serviceRequest->status >= 2.0)
                            <li class="relative pl-10">
                                <div class="absolute left-0 top-0 h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <p class="font-medium text-gray-900">Delivered</p>
                                    <p class="text-sm text-gray-500">{{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Product has been delivered to you</p>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Image -->
                @if($serviceRequest->image)
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Product Image</h4>
                    <img src="{{ $serviceRequest->image }}" alt="Product image" class="rounded-lg shadow-md max-w-full h-auto max-h-64">
                </div>
                @endif
            </div>
        @endif
    </div>
</div>