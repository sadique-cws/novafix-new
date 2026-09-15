<div class="space-y-6">
    <x-slot name="navbar_back">
        <a wire:navigate href="{{ route('franchise.manage.payments') }}" class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
    </x-slot>

    <!-- Customer Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Customer Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Customer Name</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->owner_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Contact Number</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->contact }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Email</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Service Category</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->serviceCategory->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Received By</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->receivedBy->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Service Status</p>
                    <div class="mt-1">
                        @if (in_array((string)$payment->serviceRequest->status, ['0', '1', 'pending']))
                            <x-ui.badge color="yellow">Pending</x-ui.badge>
                        @elseif(in_array((string)$payment->serviceRequest->status, ['25', '50', '2']))
                            <x-ui.badge color="blue">In Progress</x-ui.badge>
                        @elseif(in_array((string)$payment->serviceRequest->status, ['100', '3', 'completed']))
                            <x-ui.badge color="green">Completed</x-ui.badge>
                        @elseif((string)$payment->serviceRequest->status == '90')
                            <x-ui.badge color="red">Cancelled</x-ui.badge>
                        @else
                            <x-ui.badge color="gray">{{ ucfirst($payment->serviceRequest->status ?? 'Unknown') }}</x-ui.badge>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Device Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Device Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Product Name</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->product_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Brand</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->brand }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Serial Number</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->serial_no ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Color</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->color }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Problem Reported</p>
                    <p class="text-lg font-medium text-gray-900">{{ $payment->serviceRequest->problem }}</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-500 uppercase mb-1">Estimated Delivery</p>
                    <p class="text-lg font-medium text-gray-900">
                        {{ $payment->serviceRequest->estimate_delivery }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Payment Details</h3>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Payment Status</p>
                        <div class="mt-1">
                            @if ($payment->status === 'completed')
                                <x-ui.badge color="green">Completed</x-ui.badge>
                            @elseif ($payment->status === 'pending')
                                <x-ui.badge color="yellow">Pending</x-ui.badge>
                            @elseif ($payment->status === 'failed')
                                <x-ui.badge color="red">Failed</x-ui.badge>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Payment Method</p>
                        <p class="text-lg font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Transaction ID</p>
                        <p class="text-lg font-medium text-gray-900">{{ $payment->transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Payment Date</p>
                        <p class="text-lg font-medium text-gray-900">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <div class="max-w-md ml-auto space-y-3">
                        <div class="flex justify-between items-center text-gray-600">
                            <p class="font-medium">Service Amount:</p>
                            <p class="text-lg">₹{{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <p class="font-medium">Discount:</p>
                            <p class="text-lg text-green-600">- ₹{{ number_format($payment->discount, 2) }}</p>
                        </div>
                        <div class="flex justify-between items-center text-gray-600">
                            <p class="font-medium">Tax:</p>
                            <p class="text-lg">₹{{ number_format($payment->tax, 2) }}</p>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-200 pt-3">
                            <p class="text-xl font-bold text-gray-800">Total Amount:</p>
                            <p class="text-2xl font-bold text-blue-600">₹{{ number_format($payment->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                @if($payment->notes)
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <p class="text-sm font-bold text-gray-500 uppercase mb-2">Notes</p>
                        <p class="text-gray-700">{{ $payment->notes }}</p>
                    </div>
                @endif

                <!-- Payment Actions -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-8 border-t border-gray-100 pt-6">
                    @if($payment->status !== 'completed')
                        <x-ui.button wire:click="markAsPaid({{ $payment->id }})" variant="primary">
                            <i class="fas fa-check-circle mr-2"></i> Mark as Paid
                        </x-ui.button>
                    @endif
                    <x-ui.button wire:click="printReceipt({{ $payment->id }})" variant="secondary">
                        <i class="fas fa-print mr-2"></i> Print Receipt
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>