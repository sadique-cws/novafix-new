<div>
    <div class="flex-1 p-4 md:p-6 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            <!-- Header Section -->
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 bg-white p-4 rounded-lg shadow-sm">
                <div class="flex items-center space-x-4">
                    <button wire:navigate href="{{ route('staff.assigned.task') }}"
                        class="p-2 rounded-full hover:bg-gray-100 text-gray-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Service Request Details</h1>
                        <div class="flex items-center mt-1 space-x-3">
                            <span class="text-lg font-semibold text-gray-700">{{ $task->service_code }}</span>
                            @if ($paymentCompleted)
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Payment Completed
                                </span>
                            @elseif($taskRejected)
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @else
                                <span
                                    class="px-3 py-1 text-xs font-medium rounded-full 
              @if ($task->status == 0) bg-gray-100 text-gray-800
              @elseif($task->status == 25) bg-blue-100 text-blue-800
              @elseif($task->status == 50) bg-yellow-100 text-yellow-800
              @elseif($task->status == 75) bg-indigo-100 text-indigo-800
              @elseif($task->status == 100) bg-green-100 text-green-800 @endif">
                                    {{ $statusOptions[$task->status] ?? 'Unknown' }}
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">Last Updated:</span>
                        {{ $task->updated_at->format('M d, Y h:i A') }}
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer & Product Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-800">Customer & Product Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Customer Info -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-user mr-2 text-purple-600"></i> Customer Details
                                    </h3>
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Full Name</p>
                                            <p class="mt-1 text-gray-900">{{ $task->owner_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Contact Number</p>
                                            <p class="mt-1 text-gray-900">{{ $task->contact }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Email Address</p>
                                            <p class="mt-1 text-gray-900">{{ $task->email ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-box mr-2 text-purple-600"></i> Product Details
                                    </h3>
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Product Name</p>
                                            <p class="mt-1 text-gray-900">{{ $task->product_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Brand</p>
                                            <p class="mt-1 text-gray-900">{{ $task->brand }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Serial Number</p>
                                            <p class="mt-1 text-gray-900">{{ $task->serial_no ?? 'Not available' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Image -->
                            @if ($task->image)
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <p class="text-xs font-medium text-gray-500 mb-2">Product Image</p>
                                    <div class="relative w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $task->image) }}" alt="Product Image"
                                            class="w-full h-full object-contain">
                                        <a href="{{ asset('storage/' . $task->image) }}" target="_blank"
                                            class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition">
                                            <i class="fas fa-expand text-gray-600"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Problem Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-800">Problem Details</h2>
                        </div>
                        <div class="p-6">
                            <div class="prose prose-sm max-w-none">
                                <h3 class="text-sm font-medium text-gray-700">Reported Problem</h3>
                                <p class="mt-2 text-gray-800">{{ $task->problem }}</p>

                                @if ($task->technician_notes)
                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-medium text-gray-700">Technician Notes</h3>
                                        <p class="mt-2 text-gray-800 whitespace-pre-line">{{ $task->technician_notes }}
                                        </p>
                                    </div>
                                @endif

                                @if ($task->remark)
                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <h3 class="text-sm font-medium text-gray-700">Receptionist Remarks</h3>
                                        <p class="mt-2 text-gray-800">{{ $task->remark }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Service Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-800">Service Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Service Category</p>
                                    <p class="mt-1 text-gray-900">{{ $task->serviceCategory->name ?? 'Not specified' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Assigned By</p>
                                    <p class="mt-1 text-gray-900">{{ $task->receptionist->name ?? 'System' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Date Created</p>
                                    <p class="mt-1 text-gray-900">{{ $task->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Last Updated</p>
                                    <p class="mt-1 text-gray-900">{{ $task->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-800">Task Status</h2>
                        </div>
                        <div class="p-6">
                            @if (!$paymentCompleted && !$taskRejected)
                                <!-- Reject Button -->
                                <!-- Reject Button -->
                                <div class="mb-6">
                                    <button wire:click="rejectTask"
                                        class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.class="invisible">
                                            <i class="fas fa-times-circle mr-2"></i> Reject Task
                                        </span>
                                        <svg wire:loading wire:target="rejectTask"
                                            class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Payment Section (shown only when completing) -->
                                @if ($showPaymentSection)
                                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <h3 class="text-md font-medium text-gray-700 mb-4">Complete with Payment</h3>

                                        <div class="space-y-4">
                                            <!-- Payment Method -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment
                                                    Method</label>
                                                <div class="grid grid-cols-3 gap-2">
                                                    <button type="button" wire:click="$set('paymentMethod', 'cash')"
                                                        class="py-2 px-3 border rounded-md text-sm font-medium 
                                            @if ($paymentMethod === 'cash') bg-purple-100 border-purple-500 text-purple-700 @else border-gray-300 text-gray-700 bg-white hover:bg-gray-50 @endif">
                                                        Cash
                                                    </button>
                                                    <button type="button" wire:click="$set('paymentMethod', 'card')"
                                                        class="py-2 px-3 border rounded-md text-sm font-medium 
                                            @if ($paymentMethod === 'card') bg-purple-100 border-purple-500 text-purple-700 @else border-gray-300 text-gray-700 bg-white hover:bg-gray-50 @endif">
                                                        Card
                                                    </button>
                                                    <button type="button" wire:click="$set('paymentMethod', 'upi')"
                                                        class="py-2 px-3 border rounded-md text-sm font-medium 
                                            @if ($paymentMethod === 'upi') bg-purple-100 border-purple-500 text-purple-700 @else border-gray-300 text-gray-700 bg-white hover:bg-gray-50 @endif">
                                                        UPI
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Payment Amount -->
                                            <div>
                                                <label for="paymentAmount"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Amount
                                                    (₹)</label>
                                                <input type="number" wire:model="paymentAmount" id="paymentAmount"
                                                    class="block w-full py-1 px-2 outline:none border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                            </div>

                                            <!-- Payment Reference -->
                                            <div>
                                                <label for="paymentReference"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Reference/Note</label>
                                                <input type="text" wire:model="paymentReference"
                                                    id="paymentReference"
                                                    class="block w-full py-1 px-2 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex space-x-3 pt-2">
                                                <button type="button" wire:click="completeWithPayment"
                                                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                                                    Complete Payment
                                                </button>
                                                <button type="button" wire:click="cancelPayment"
                                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md text-sm font-medium">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Status Selector -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Change
                                        Status</label>
                                    <select id="status" wire:model="selectedStatus" wire:change="updateStatus"
                                        class="block w-full border py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                                        @foreach ($statusOptions as $value => $label)
                                            @if ($value != 90)
                                                <option value="{{ $value }}"
                                                    @if ($value == $task->status) selected @endif>
                                                    {{ $label }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($taskRejected)
                                <!-- Show rejected message -->
                                <div class="p-4 bg-red-50 rounded-lg border border-red-200 text-center">
                                    <i class="fas fa-times-circle text-red-500 text-3xl mb-2"></i>
                                    <h3 class="text-lg font-medium text-red-800">Task Rejected</h3>
                                    <p class="text-sm text-red-600 mt-1">
                                        This task was rejected on {{ $task->updated_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            @else
                                <!-- Show payment completed message (same as before) -->
                                <div class="p-4 bg-green-50 rounded-lg border border-green-200 text-center">
                                    <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                                    <h3 class="text-lg font-medium text-green-800">Payment Completed</h3>
                                    <p class="text-sm text-green-600 mt-1">
                                        ₹{{ number_format($task->payments->first()->total_amount, 2) }} received via
                                        {{ ucfirst($task->payments->first()->payment_method) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment History Card -->
                    @if ($task->payments->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-800">Payment History</h2>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach ($task->payments as $payment)
                                        <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                            <div class="flex justify-between">
                                                <span
                                                    class="font-medium">₹{{ number_format($payment->total_amount, 2) }}</span>
                                                <span
                                                    class="text-sm text-gray-500">{{ $payment->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                {{ ucfirst($payment->payment_method) }} payment
                                                @if ($payment->payment_method === 'cash')
                                                    (Received by: {{ $payment->receiver->name ?? 'Staff' }})
                                                @endif
                                            </div>
                                            @if ($payment->notes)
                                                <div class="text-xs text-gray-500 mt-1">Note: {{ $payment->notes }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-800">Quick Actions</h2>
                        </div>
                        <div class="p-4 grid grid-cols-2 gap-3">
                            <a href="#" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                                <div
                                    class="mx-auto w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-print"></i>
                                </div>
                                <span class="text-xs font-medium">Print Ticket</span>
                            </a>
                            <a href="#" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                                <div
                                    class="mx-auto w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span class="text-xs font-medium">Email Customer</span>
                            </a>
                            <a href="#" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                                <div
                                    class="mx-auto w-10 h-10 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <span class="text-xs font-medium">Create Invoice</span>
                            </a>
                            <a href="#" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                                <div
                                    class="mx-auto w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <span class="text-xs font-medium">Report Issue</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .toast-success {
            background-color: #38a169;
            border-left: 6px solid #2f855a;
        }

        .toast-success .toast-title {
            font-weight: 600;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .toast-success .toast-message {
            font-size: 0.95em;
            line-height: 1.4;
        }

        .toast-close-button {
            color: white;
            opacity: 0.8;
            font-weight: normal;
        }

        .toast-close-button:hover {
            opacity: 1;
            color: white;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('notify', (event) => {
                    toastr[event.type](event.message, event.title, {
                        progressBar: true,
                        closeButton: true,
                        positionClass: 'toast-bottom-right',
                        timeOut: event.duration || 3000,
                        extendedTimeOut: 1000,
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut',
                        tapToDismiss: false,
                        closeHtml: '<button><i class="fas fa-times"></i></button>'
                    });
                });
            });
        </script>
    @endpush
</div>
