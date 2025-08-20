<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl  text-gray-800">Payment Details</h2>
            <p class="text-gray-600">Service Code: {{ $payment->serviceRequest->service_code }}</p>
        </div>
        <a wire:navigate href="{{ route('franchise.manage.payments') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
        </a>
    </div>

    <!-- Customer Information Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Customer Name</p>
                    <p class="font-medium">{{ $payment->serviceRequest->owner_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Contact Number</p>
                    <p class="font-medium">{{ $payment->serviceRequest->contact }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $payment->serviceRequest->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Service Category</p>
                    <p class="font-medium">{{ $payment->serviceRequest->serviceCategory->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Received By</p>
                    <p class="font-medium">{{ $payment->receivedBy->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Service Status</p>
                    <p class="font-medium">
                        <span class="px-2 py-1 rounded-full text-xs 
                            {{ $payment->serviceRequest->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($payment->serviceRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($payment->serviceRequest->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Device Information Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Device Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Product Name</p>
                    <p class="font-medium">{{ $payment->serviceRequest->product_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Brand</p>
                    <p class="font-medium">{{ $payment->serviceRequest->brand }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Serial Number</p>
                    <p class="font-medium">{{ $payment->serviceRequest->serial_no ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Color</p>
                    <p class="font-medium">{{ $payment->serviceRequest->color }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Problem Reported</p>
                    <p class="font-medium">{{ $payment->serviceRequest->problem }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Estimated Delivery</p>
                    <p class="font-medium">
                        {{ $payment->serviceRequest->estimate_delivery   }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Details</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Payment Status</p>
                        <p class="font-medium">
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Method</p>
                        <p class="font-medium">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Transaction ID</p>
                        <p class="font-medium">{{ $payment->transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Date</p>
                        <p class="font-medium">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <p class="text-gray-600">Service Amount:</p>
                            <p class="font-medium">₹{{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-gray-600">Discount:</p>
                            <p class="font-medium">₹{{ number_format($payment->discount, 2) }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-gray-600">Tax:</p>
                            <p class="font-medium">₹{{ number_format($payment->tax, 2) }}</p>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2">
                            <p class="text-gray-800 font-semibold">Total Amount:</p>
                            <p class="text-blue-600 ">₹{{ number_format($payment->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                @if($payment->notes)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Notes</p>
                        <p class="text-gray-700">{{ $payment->notes }}</p>
                    </div>
                @endif

                <!-- Payment Actions -->
                <div class="flex justify-end space-x-3 mt-6">
                    @if($payment->status !== 'completed')
                        <button wire:click="markAsPaid({{ $payment->id }})" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check-circle mr-2"></i> Mark as Paid
                        </button>
                    @endif
                    <button wire:click="printReceipt({{ $payment->id }})" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-print mr-2"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>