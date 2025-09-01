<div class="min-h-screen py-6 px-4 md:py-10 md:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 mb-6 md:mb-8 shadow-lg">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                Track Your Service Request
            </h2>

            @if (session()->has('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="track" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Service Code</label>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <input type="text" wire:model="service_code"
                            placeholder="Enter your service code (e.g., SO3l9s-00001)"
                            class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-shadow">
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors font-medium shadow-sm">
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
            <div class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800">Service Request Details</h3>
                    <a wire:navigate href="{{route('receipt.view', $serviceRequest->id)}}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Receipt
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Basic Information -->
                    <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Basic Information</h4>
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
                    <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Status Information</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Current Status:</span>
                                <p
                                    class="text-lg font-semibold 
                                    @if ($serviceRequest->status == -1) text-red-600 
                                    @elseif($serviceRequest->status == 0) text-blue-600 
                                    @elseif($serviceRequest->status == 1.0) text-green-600 
                                    @elseif($serviceRequest->status == 2.0) text-purple-600 
                                    @else text-gray-600 @endif">
                                    @if ($serviceRequest->status == 90)
                                        Cancelled
                                    @elseif($serviceRequest->status == 0)
                                        Pending
                                    @elseif($serviceRequest->status == 100)
                                        Completed
                                    @elseif($serviceRequest->status == 50)
                                        Processing
                                    @else
                                        Unknown
                                    @endif
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Category:</span>
                                <p>{{ $serviceRequest->category->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Franchise:</span>
                                <p>{{ $serviceRequest->franchise->franchise_name }}</p>
                            </div>
                            @if ($serviceRequest->technician)
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Technician:</span>
                                    <p>{{ $serviceRequest->technician->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Problem Description -->
                <div class="mb-6 border border-gray-200 rounded-lg p-4 shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2 border-b border-gray-200 pb-2">Problem Description</h4>
                    <p class="text-gray-800 leading-relaxed">{{ $serviceRequest->problem }}</p>
                </div>

                <!-- Timeline -->
                <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Service Timeline</h4>
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>

                        <ul class="space-y-6">
                            <!-- Request Received -->
                            <li class="relative pl-10">
                                <div
                                    class="absolute left-0 top-1 h-8 w-8 rounded-full bg-red-400 flex items-center justify-center border-2 border-white shadow-md">
                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <p class="font-medium text-gray-900">Request Success</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $serviceRequest->created_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Your service request has been registered</p>
                            </li>

                            <!-- In Progress -->
                            @if ($serviceRequest->status >= 0)
                                <li class="relative pl-10">
                                    <div
                                        class="absolute left-0 top-1 h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center border-2 border-white shadow-md">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <p class="font-medium text-gray-900">In pending</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Your product is being serviced</p>
                            </li>
                            @endif

                            <!-- Processing -->
                            @if ($serviceRequest->status >= 50)
                                <li class="relative pl-10">
                                    <div
                                        class="absolute left-0 top-1 h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center border-2 border-white shadow-md">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <p class="font-medium text-gray-900">Processing</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Service has in Process</p>
                            </li>
                            @endif

                            <!-- Completed -->
                            @if ($serviceRequest->status >= 100)
                                <li class="relative pl-10">
                                    <div
                                        class="absolute left-0 top-1 h-8 w-8 rounded-full bg-green-500 flex items-center justify-center border-2 border-white shadow-md">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <p class="font-medium text-gray-900">Completed</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Service has been completed</p>
                            </li>
                            @endif

                            <!-- Delivered -->
                            @if ($serviceRequest->delivery_status >= 1)
                                <li class="relative pl-10">
                                    <div
                                        class="absolute left-0 top-1 h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center border-2 border-white shadow-md">
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <p class="font-medium text-gray-900">Delivered</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $serviceRequest->updated_at->format('M j, Y') }}</p>
                                </div>
                                <p class="text-sm text-gray-600">Product has been delivered to you</p>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Product Image -->
                @if ($serviceRequest->image)
                    <div class="mt-8 border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-2">Product Image</h4>
                        <img src="{{ $serviceRequest->image }}" alt="Product image"
                            class="rounded-lg border border-gray-200 w-full h-auto max-h-64 object-contain">
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Fixed Track Button for Mobile -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 md:hidden z-50 shadow-lg">
        <form wire:submit.prevent="track" class="flex space-x-2">
            <input type="text" wire:model="service_code"
                placeholder="Enter service code"
                class="flex-1 rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <button type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors font-medium">
                Track
            </button>
        </form>
    </div>
</div>