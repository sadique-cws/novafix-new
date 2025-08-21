<div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-6 md:py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-md mb-4 sm:mb-6 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 sm:py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <a href="{{ route('frontdesk.servicerequest.manage') }}"
                    class="p-2 rounded-full hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-arrow-left text-gray-600 text-base sm:text-lg"></i>
                </a>
                <div>
                    <h1 class="text-lg sm:text-xl md:text-2xl  text-gray-900">Service Request Details</h1>
                    <div class="flex flex-wrap items-center mt-2 space-x-2 sm:space-x-3">
                        <span class="text-xs sm:text-sm font-medium text-gray-600 bg-gray-200 px-2.5 sm:px-3 py-1 rounded-full">SR-{{ $task->service_code }}</span>
                        @if ($paymentCompleted)
                            <span class="inline-flex items-center px-2.5 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1.5"></i> Payment Completed
                            </span>
                        @elseif($taskRejected)
                            <span class="inline-flex items-center px-2.5 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1.5"></i> Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium 
                                @if ($task->status == 0) bg-gray-100 text-gray-800
                                @elseif($task->status == 25) bg-blue-100 text-blue-800
                                @elseif($task->status == 50) bg-yellow-100 text-yellow-800
                                @elseif($task->status == 75) bg-indigo-100 text-indigo-800
                                @elseif($task->status == 100) bg-green-100 text-green-800 @endif">
                                <i class="fas 
                                    @if ($task->status == 0) fa-clock 
                                    @elseif($task->status == 25) fa-tasks 
                                    @elseif($task->status == 50) fa-cog 
                                    @elseif($task->status == 75) fa-check-circle 
                                    @elseif($task->status == 100) fa-check-double @endif 
                                    mr-1.5 text-xs sm:text-sm"></i>
                                {{ $statusOptions[$task->status] ?? 'Unknown' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-3 sm:mt-0">
                <span class="text-xs sm:text-sm text-gray-600 bg-gray-100 px-3 sm:px-4 py-1.5 rounded-full">
                    <i class="far fa-clock mr-1.5"></i> Last Updated: {{ $task->updated_at->format('M d, Y h:i A') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Customer & Product Info Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-tag text-indigo-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Customer & Product Information
                    </h2>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Customer Info -->
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle text-indigo-600 text-lg sm:text-xl mr-2 sm:mr-3"></i>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Customer Details</h3>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Full Name</p>
                                    <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium truncate">{{ $task->owner_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Contact Number</p>
                                    <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->contact }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Email Address</p>
                                    <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium truncate">{{ $task->email ?? 'Not provided' }}</p>
                                </div>font-semibol
                            </div>
                        </div>
                        <!-- Product Info -->
                        <div class="space-y-3 sm:space-y-4">
                            <div class="flex items-center">
                                <i class="fas fa-box-open text-indigo-600 text-lg sm:text-xl mr-2 sm:mr-3"></i>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Product Details</h3>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Product Name</p>
                                    <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium truncate">{{ $task->product_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Brand</p>
                                    <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->brand }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Serial Number</p>
                                    <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->serial_no ?? 'Not available' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product Image -->
                    @if ($task->image)
                        <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200">
                            <div class="flex items-center mb-3 sm:mb-4">
                                <i class="fas fa-camera text-blue-600 text-lg sm:text-xl mr-2 sm:mr-3"></i>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Product Image</h3>
                            </div>
                            <div class="relative w-full h-48 sm:h-64 rounded-lg overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $task->image) }}" alt="Product Image"
                                    class="w-full h-full object-contain p-3 sm:p-4">
                                <a href="{{ asset('storage/' . $task->image) }}" target="_blank"
                                    class="absolute bottom-3 right-3 sm:bottom-4 sm:right-4 bg-white p-1.5 sm:p-2 rounded-full shadow-md hover:bg-gray-100 transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-expand text-gray-600 text-sm sm:text-base"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Problem Details Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-cyan-50 to-blue-50">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bug text-blue-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Problem Details
                    </h2>
                </div>
                <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                    <div>
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-700 uppercase mb-2">Reported Problem</h3>
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg border border-gray-200">
                            <p class="text-sm sm:text-base text-gray-800 leading-relaxed">{{ $task->problem }}</p>
                        </div>
                    </div>
                    @if ($task->technician_notes)
                        <div class="pt-4 border-t border-gray-200">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-700 uppercase mb-2">Technician Notes</h3>
                            <div class="bg-blue-50 p-3 sm:p-4 rounded-lg border border-blue-200">
                                <p class="text-sm sm:text-base text-gray-800 leading-relaxed">{{ $task->technician_notes }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($task->remark)
                        <div class="pt-4 border-t border-gray-200">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-700 uppercase mb-2">Rejection Reason</h3>
                            <div class="bg-red-50 p-3 sm:p-4 rounded-lg border border-red-200">
                                <p class="text-sm sm:text-base text-red-800">{{ $task->remark }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Service Info Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-gray-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Service Information
                    </h2>
                </div>
                <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <i class="fas fa-list-alt text-gray-600 text-base sm:text-lg mt-1"></i>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Service Category</p>
                            <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->serviceCategory->name ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <i class="fas fa-user-shield text-gray-600 text-base sm:text-lg mt-1"></i>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Assigned By</p>
                            <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->receptionist->name ?? 'System' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <i class="far fa-calendar-plus text-gray-600 text-base sm:text-lg mt-1"></i>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Date Created</p>
                            <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-2 sm:space-x-3">
                        <i class="fas fa-sync-alt text-gray-600 text-base sm:text-lg mt-1"></i>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Last Updated</p>
                            <p class="mt-1 text-sm sm:text-base text-gray-900 font-medium">{{ $task->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Update Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-tasks text-indigo-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Task Status
                    </h2>
                </div>
                <div class="p-4 sm:p-6">
                    @if (!$paymentCompleted && !$taskRejected)
                        <!-- Progress Bar -->
                        <div class="mb-4 sm:mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs sm:text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-xs sm:text-sm font-medium text-gray-700">{{ $task->status }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 sm:h-3">
                                <div class="bg-indigo-600 h-2.5 sm:h-3 rounded-full transition-all duration-500 ease-in-out"
                                    style="width: {{ $task->status }}%"></div>
                            </div>
                        </div>
                        <!-- Reject Button -->
                        <button wire:click="rejectTask"
                            class="w-full flex items-center justify-center py-2.5 px-4 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-times-circle mr-2"></i> Reject Task
                            <svg wire:loading wire:target="rejectTask"
                                class="animate-spin h-4 sm:h-5 w-4 sm:w-5 ml-2 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                        <!-- Payment Section -->
                        @if ($showPaymentSection)
                            <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-blue-50 rounded-lg">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                                    <i class="fas fa-rupee-sign text-blue-600 mr-2"></i> Complete Task Payment
                                </h3>
                                <div class="space-y-3 sm:space-y-4">
                                    <div>
                                        <label for="paymentAmount"
                                            class="block text-xs font-medium text-gray-700 uppercase">Amount (₹)</label>
                                        <div class="mt-1 relative rounded-md">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">₹</span>
                                            <input type="number" wire:model="paymentAmount" id="paymentAmount"
                                                class="block w-full pl-8 pr-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                                placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 uppercase">Payment Method</label>
                                        <div class="mt-2 grid grid-cols-3 gap-2">
                                            <label class="flex items-center">
                                                <input type="radio" wire:model="payment_method" value="cash"
                                                    class="h-4 w-4 text-indigo-600">
                                                <span class="ml-2 text-xs sm:text-sm">Cash</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" wire:model="payment_method" value="card"
                                                    class="h-4 w-4 text-indigo-600">
                                                <span class="ml-2 text-xs sm:text-sm">Card</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" wire:model="payment_method" value="upi"
                                                    class="h-4 w-4 text-indigo-600">
                                                <span class="ml-2 text-xs sm:text-sm">UPI</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="paymentReference"
                                            class="block text-xs font-medium text-gray-700 uppercase">Reference/Note</label>
                                        <input type="text" wire:model="paymentReference" id="paymentReference"
                                            class="block w-full py-2 px-3 text-sm border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                            placeholder="Enter payment reference">
                                    </div>
                                    <div class="flex space-x-2 sm:space-x-3">
                                        <button wire:click="completeWithPayment"
                                            class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105">Pay Now</button>
                                        <button wire:click="cancelPayment"
                                            class="flex-1 bg-white border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Status Selector -->
                        <div class="mt-4 sm:mt-6">
                            <label for="status" class="block text-xs font-medium text-gray-700 uppercase">Update Status</label>
                            <div class="relative mt-1">
                                <select id="status" wire:model="selectedStatus" wire:change="updateStatus"
                                    class="block w-full py-2.5 px-3 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    @foreach ($statusOptions as $value => $label)
                                        @if ($value != 90)
                                            <option value="{{ $value }}"
                                                @if ($value == $task->status) selected @endif>
                                                {{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 text-sm"></i>
                            </div>
                        </div>
                    @elseif($taskRejected)
                        <div class="p-3 sm:p-4 bg-red-50 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-times-circle text-red-600 text-lg sm:text-xl mr-2 sm:mr-3 mt-1"></i>
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-red-800">Task Rejected</h3>
                                    <div class="mt-2 text-xs sm:text-sm text-red-700 space-y-2">
                                        <p class="flex items-center"><i class="far fa-calendar-times mr-1.5"></i>
                                            Rejected on: {{ $task->updated_at->format('M d, Y h:i A') }}</p>
                                        @if ($task->remark)
                                            <p class="flex items-start"><i
                                                    class="fas fa-comment-alt mr-1.5 mt-1"></i> Reason:
                                                {{ $task->remark }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-3 sm:p-5 bg-green-50 rounded-lg">
                            <div class="flex items-start gap-3 sm:gap-4">
                                <div class="p-2 bg-green-100 rounded-full">
                                    <svg class="w-5 sm:w-6 h-5 sm:h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Payment Completed</h3>
                                    <div class="mt-2 sm:mt-3 space-y-2 text-xs sm:text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>Completed on {{ $task->updated_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        @if ($task->payments->isNotEmpty())
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="font-medium">₹{{ number_format($task->payments->first()->total_amount, 2) }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="mr-2">Status:</span>
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full 
                                                        @if ($task->payments->first()->status == 'completed') bg-green-100 text-green-800
                                                        @elseif($task->payments->first()->status == 'pending') bg-yellow-100 text-yellow-800
                                                        @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($task->payments->first()->status) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment History Card -->
            @if ($task->payments->count() > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-green-50 to-teal-50">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-receipt text-green-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Payment History
                        </h2>
                    </div>
                    <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                        @foreach ($task->payments as $payment)
                            <div class="border-b border-gray-200 pb-3 sm:pb-4 last:border-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span
                                            class=" text-sm sm:text-base text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</span>
                                        <div class="mt-1 text-xs sm:text-sm">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    @if ($payment->payment_method === 'cash') bg-blue-100 text-blue-800
                                                    @elseif($payment->payment_method === 'card') bg-purple-100 text-purple-800
                                                    @elseif($payment->payment_method === 'online') bg-teal-100 text-teal-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                <i
                                                    class="fas 
                                                        @if ($payment->payment_method === 'cash') fa-money-bill-wave 
                                                        @elseif($payment->payment_method === 'card') fa-credit-card 
                                                        @elseif($payment->payment_method === 'online') fa-globe 
                                                        @else fa-question-circle @endif 
                                                        mr-1 text-xs"></i>
                                                {{ ucfirst($payment->payment_method) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="text-xs sm:text-sm text-gray-500">{{ $payment->created_at->format('M d, Y') }}</span>
                                        <div class="mt-1">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    @if ($payment->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if ($payment->notes)
                                    <div class="mt-2 text-xs sm:text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                        <i class="far fa-sticky-note mr-1"></i> {{ $payment->notes }}
                                    </div>
                                @endif
                                @if ($payment->receiver)
                                    <div class="mt-2 text-xs sm:text-sm text-gray-500">
                                        <i class="fas fa-user-tie mr-1"></i> Processed by:
                                        {{ $payment->receiver->name }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Delivery Status -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-yellow-50 to-orange-50">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-truck text-yellow-600 mr-2 sm:mr-3 text-base sm:text-lg"></i> Delivery Status
                    </h2>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                        @if ($task->delivery_status == '1')
                            <span class="text-green-600 font-semibold text-sm sm:text-base">
                                <i class="fas fa-check-circle mr-2"></i> Delivered
                            </span>
                        @else
                            <span class="text-yellow-600 font-semibold text-sm sm:text-base">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Not Delivered
                            </span>
                            @if ($task->payments->where('status', 'completed')->count() > 0 && $task->status == '100')
                                <button wire:click="initiateDelivery"
                                    class="mt-3 mr-2 sm:mt-0 px-3 sm:px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-truck mr-2"></i> Otp 
                                </button>
                                  <button wire:click="directDelivery"
                                    class="mt-3 ml-2 sm:mt-0 px-3 sm:px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-truck mr-2"></i>Direct
                                </button>
                            @endif
                            
                        @endif
                    </div>
                </div>
            </div>

            <!-- OTP Modal -->
            @if ($showOtpModal)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-3 sm:px-0">
                    <div class="bg-white rounded-lg p-4 sm:p-6 w-full max-w-sm sm:max-w-md transform transition-all duration-300">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Verify OTP</h3>

                        @if (session()->has('otp-info'))
                            <div class="bg-blue-100 text-blue-800 p-2 sm:p-3 rounded mb-3 sm:mb-4 text-xs sm:text-sm">
                                {{ session('otp-info') }}
                            </div>
                        @endif

                        @if (session()->has('otp-error'))
                            <div class="bg-red-100 text-red-800 p-2 sm:p-3 rounded mb-3 sm:mb-4 text-xs sm:text-sm">
                                {{ session('otp-error') }}
                            </div>
                        @endif

                        <div class="mb-3 sm:mb-4">
                            <label class="block text-xs sm:text-sm text-gray-700 mb-2">Enter OTP sent to {{ $customerMobile }}</label>
                            <input type="text" wire:model="otp" class="w-full px-3 py-2 text-sm border rounded-md focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                maxlength="6" @if ($otpTimeout) disabled @endif
                                placeholder="6-digit OTP">
                            <div class="mt-2 text-right">
                                <span class="text-xs sm:text-sm font-medium {{ $otpExpired ? 'text-red-600' : 'text-gray-600' }}" id="otpTimer">
                                    @if ($otpExpired)
                                        OTP expired
                                    @else
                                        Time remaining: <span id="otpCountdown">{{ $countdownSeconds }}</span> seconds
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-3">
                            <button wire:click="verifyOtpAndMarkDelivered"
                                class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200 transform hover:scale-105"
                                @if ($otpTimeout) disabled @endif>
                                Verify OTP
                            </button>
                            @if ($otpTimeout)
                                <button wire:click="initiateDelivery"
                                    class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-all duration-200 transform hover:scale-105">
                                    Resend OTP
                                </button>
                            @endif
                            <button wire:click="$set('showOtpModal', false)"
                                class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-all duration-200 transform hover:scale-105">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Rejection Reason Modal -->
    @if ($showRejectionModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 px-3 sm:px-0">
            <div class="bg-white rounded-xl shadow-xl max-w-sm sm:max-w-lg w-full p-4 sm:p-6 transform transition-all duration-300">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-red-100 p-2 sm:p-3 rounded-full">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="ml-3 sm:ml-4 flex-1">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">Reject Service Request</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-600">Please provide a reason for rejecting this service request.</p>
                        <textarea wire:model="rejectionReason" rows="4"
                            class="mt-3 sm:mt-4 w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                            placeholder="Enter rejection reason..."></textarea>
                        @error('rejectionReason')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                    <button wire:click="confirmRejection"
                        class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 transform hover:scale-105">Confirm Rejection</button>
                    <button wire:click="$set('showRejectionModal', false)"
                        class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">Cancel</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Message -->
    @if (session()->has('delivery-success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-4 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg flex items-center text-sm sm:text-base transform transition-all duration-300"
            x-transition:enter="transform ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transform ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4">
            <i class="fas fa-check-circle mr-2"></i> {{ session('delivery-success') }}
        </div>
    @endif

    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (event) => {
                toastr[event.type](event.message, event.title, {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut',
                });
                if (event.type === 'success') Livewire.emit('taskUpdated');
                if (event.type === 'error') Livewire.emit('taskError');
                if (event.type === 'info') Livewire.emit('taskInfo');
            });

            let countdownInterval;

            // Start the countdown when OTP is sent
            Livewire.on('otp-sent', () => {
                // Clear any existing timer
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }

                // Get initial value from Livewire
                let secondsLeft = @this.get('countdownSeconds');

                // Start new countdown
                countdownInterval = setInterval(() => {
                    secondsLeft--;

                    // Update Livewire property
                    @this.set('countdownSeconds', secondsLeft);

                    // Update the display
                    const countdownEl = document.getElementById('otpCountdown');
                    if (countdownEl) {
                        countdownEl.textContent = secondsLeft;
                    }

                    // Change color when below 10 seconds
                    const timerEl = document.querySelector('#otpTimer');
                    if (timerEl) {
                        if (secondsLeft <= 10) {
                            timerEl.classList.remove('text-gray-600');
                            timerEl.classList.add('text-red-600');
                        } else {
                            timerEl.classList.add('text-gray-600');
                            timerEl.classList.remove('text-red-600');
                        }
                    }

                    // Handle expiration
                    if (secondsLeft <= 0) {
                        clearInterval(countdownInterval);
                        @this.set('otpExpired', true);
                    }
                }, 1000);
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('taskUpdated', () => toastr.success('Task updated successfully!', 'Success'));
            Livewire.on('taskError', () => toastr.error('An error occurred while updating the task.', 'Error'));
            Livewire.on('taskInfo', () => toastr.info('Please check the task details.', 'Info'));
        });
    </script>
    @endscript
</div>