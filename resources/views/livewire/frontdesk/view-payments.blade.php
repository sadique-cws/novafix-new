<div class="max-w-4xl mx-auto py-4 sm:py-6 px-3 sm:px-4 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6">
        <div>
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">Payment Details</h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Service Code: {{ $serviceRequest->service_code }}</p>
        </div>
        <a wire:navigate href="{{ route('frontdesk.manage.payments') }}"
            class="mt-3 sm:mt-0 px-3 sm:px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 transform hover:scale-105 flex items-center">
            <i class="fas fa-arrow-left mr-2 text-sm sm:text-base"></i> Back to Payments
        </a>
    </div>

    <!-- Customer Information Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-4 sm:mb-6 transform transition-all duration-200 hover:shadow-lg">
        <div class="p-4 sm:p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-user-circle text-indigo-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Customer Information
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Customer Name</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900 truncate">{{ $serviceRequest->owner_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Contact Number</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $serviceRequest->contact }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Email</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900 truncate">{{ $serviceRequest->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Service Category</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $serviceRequest->serviceCategory->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Device Information Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-4 sm:mb-6 transform transition-all duration-200 hover:shadow-lg">
        <div class="p-4 sm:p-6 bg-gradient-to-r from-cyan-50 to-blue-50">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-mobile-alt text-blue-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Device Information
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Product Name</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900 truncate">{{ $serviceRequest->product_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Brand</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $serviceRequest->brand }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Serial Number</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $serviceRequest->serial_no ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Color</p>
                    <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $serviceRequest->color }}</p>
                </div>
                <div class="col-span-1 sm:col-span-2">
                    <p class="text-xs font-medium text-gray-500 uppercase">Problem Reported</p>
                    <p class="mt-1 text-sm sm:text-base text-gray-900">{{ $serviceRequest->problem }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-200 hover:shadow-lg">
        <div class="p-4 sm:p-6 bg-gradient-to-r from-green-50 to-teal-50">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-receipt text-green-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Payment Details
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            @if($payment)
                <div class="space-y-4 sm:space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Payment Status</p>
                            <p class="mt-1 font-medium">
                                <span class="px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold 
                                    {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    <i class="fas 
                                        {{ $payment->status === 'completed' ? 'fa-check-circle' : 
                                           ($payment->status === 'pending' ? 'fa-clock' : 'fa-times-circle') }} 
                                        mr-1"></i>
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Payment Method</p>
                            <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">
                                <i class="fas 
                                    {{ $payment->payment_method === 'cash' ? 'fa-money-bill-wave' : 
                                       ($payment->payment_method === 'card' ? 'fa-credit-card' : 'fa-globe') }} 
                                    mr-1"></i>
                                {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Transaction ID</p>
                            <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $payment->transaction_id ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Payment Date</p>
                            <p class="mt-1 text-sm sm:text-base font-medium text-gray-900">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-3 sm:pt-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Service Amount:</p>
                                <p class="text-sm sm:text-base font-medium text-gray-900">₹{{ number_format($serviceRequest->service_amount, 2) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Discount:</p>
                                <p class="text-sm sm:text-base font-medium text-gray-900">₹{{ number_format($payment->discount, 2) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Tax:</p>
                                <p class="text-sm sm:text-base font-medium text-gray-900">₹{{ number_format($payment->tax, 2) }}</p>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-2">
                                <p class="text-sm sm:text-base text-gray-800 font-semibold">Total Amount:</p>
                                <p class="text-sm sm:text-base text-blue-600 font-bold">₹{{ number_format($payment->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    @if($payment->notes)
                        <div class="mt-4 sm:mt-6">
                            <p class="text-xs font-medium text-gray-500 uppercase">Notes</p>
                            <p class="mt-1 text-sm sm:text-base text-gray-700 bg-gray-50 p-2 sm:p-3 rounded-lg">{{ $payment->notes }}</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-6 sm:py-8">
                    <i class="fas fa-receipt text-3xl sm:text-4xl text-gray-300 mb-3 sm:mb-4"></i>
                    <h4 class="text-base sm:text-lg font-medium text-gray-500">No Payment Record Found</h4>
                    <p class="text-xs sm:text-sm text-gray-400 mt-1">Payment details not available for this service request</p>
                </div>
            @endif
        </div>
    </div>
</div>