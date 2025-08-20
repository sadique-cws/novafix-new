<div>
    <div>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-100">
                    <div class="flex items-center">
                        <button wire:navigate href="{{ route('staff.assigned.task') }}"
                            class="mr-4 p-2 rounded-lg hover:bg-gray-50 text-gray-600 transition duration-150 ease-in-out">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl  text-gray-800 leading-tight">Service Request Details</h1>
                            <div class="flex items-center mt-1 space-x-3">
                                <span class="text-sm font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">SR-{{ $task->service_code }}</span>
                                @if ($paymentCompleted)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Task Completed
                                    </span>
                                @elseif($taskRejected)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
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
                                            mr-1"></i>
                                        {{ $statusOptions[$task->status] ?? 'Unknown' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center">
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg">
                            <i class="far fa-clock mr-1"></i>
                            <span class="font-medium">Last Updated:</span>
                            {{ $task->updated_at->format('M d, Y h:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer & Product Info Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-100">
                            <h2 class="text-lg  text-gray-800 flex items-center">
                                <i class="fas fa-user-tag text-purple-600 mr-3"></i>
                                Customer & Product Information
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Customer Info -->
                                <div>
                                    <div class="flex items-center mb-4">
                                        <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-user-circle text-purple-600 text-lg"></i>
                                        </div>
                                        <h3 class="text-md  text-gray-700">Customer Details</h3>
                                    </div>
                                    <div class="space-y-4 pl-11">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</p>
                                            <p class="mt-1 text-gray-900 font-medium">{{ $task->owner_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Number</p>
                                            <p class="mt-1 text-gray-900 font-medium">{{ $task->contact }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email Address</p>
                                            <p class="mt-1 text-gray-900 font-medium">{{ $task->email ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div>
                                    <div class="flex items-center mb-4">
                                        <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-box-open text-indigo-600 text-lg"></i>
                                        </div>
                                        <h3 class="text-md  text-gray-700">Product Details</h3>
                                    </div>
                                    <div class="space-y-4 pl-11">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</p>
                                            <p class="mt-1 text-gray-900 font-medium">{{ $task->product_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</p>
                                            <p class="mt-1 text-gray-900 font-medium">{{ $task->brand }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</p>
                                            <p class="mt-1 text-gray-900 font-medium">{{ $task->serial_no ?? 'Not available' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Image -->
                            @if ($task->image)
                                <div class="mt-8 pt-6 border-t border-gray-100">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-camera text-blue-600 text-lg"></i>
                                        </div>
                                        <h3 class="text-md  text-gray-700">Product Image</h3>
                                    </div>
                                    <div class="pl-11">
                                        <div class="relative w-full h-56 bg-gray-50 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                            <img src="{{ asset('storage/' . $task->image) }}" alt="Product Image"
                                                class="w-full h-full object-contain p-2">
                                            <a href="{{ asset('storage/' . $task->image) }}" target="_blank"
                                                class="absolute bottom-3 right-3 bg-white p-2 rounded-lg shadow-md hover:bg-gray-100 transition duration-150 ease-in-out">
                                                <i class="fas fa-expand text-gray-600"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Problem Details Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-100">
                            <h2 class="text-lg  text-gray-800 flex items-center">
                                <i class="fas fa-bug text-blue-600 mr-3"></i>
                                Problem Details
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-sm  text-gray-700 uppercase tracking-wider mb-2">Reported Problem</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <p class="text-gray-800 whitespace-pre-line">{{ $task->problem }}</p>
                                    </div>
                                </div>

                                @if ($task->technician_notes)
                                    <div class="pt-4 border-t border-gray-100">
                                        <h3 class="text-sm  text-gray-700 uppercase tracking-wider mb-2">Technician Notes</h3>
                                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                            <p class="text-gray-800 whitespace-pre-line">{{ $task->technician_notes }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($task->remark)
                                    <div class="pt-4 border-t border-gray-100">
                                        <h3 class="text-sm  text-gray-700 uppercase tracking-wider mb-2">Rejection Reason</h3>
                                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                            <p class="text-red-800">{{ $task->remark }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Service Info Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-100">
                            <h2 class="text-lg  text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-gray-600 mr-3"></i>
                                Service Information
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-list-alt text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Service Category</p>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $task->serviceCategory->name ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user-shield text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</p>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $task->receptionist->name ?? 'System' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                        <i class="far fa-calendar-plus text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</p>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $task->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-sync-alt text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</p>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $task->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
                            <h2 class="text-lg  text-gray-800 flex items-center">
                                <i class="fas fa-tasks text-indigo-600 mr-3"></i>
                                Task Status
                            </h2>
                        </div>
                        <div class="p-6">
                            @if (!$paymentCompleted && !$taskRejected)
                                <!-- Status Progress Bar -->
                                <div class="mb-6">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Progress</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $task->status }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $task->status }}%"></div>
                                    </div>
                                </div>

                                <!-- Reject Button -->
                                <div class="mb-6">
                                    <button wire:click="rejectTask"
                                        class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.class="invisible" class="flex items-center">
                                            <i class="fas fa-times-circle mr-2"></i> Reject Task
                                        </span>
                                        <svg wire:loading wire:target="rejectTask"
                                            class="animate-spin h-4 w-4 text-white"
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
                                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <h3 class="text-md  text-gray-700 mb-4 flex items-center">
                                            <i class="fas fa-rupee-sign text-blue-600 mr-2"></i>
                                            Complete Task Payment
                                        </h3>

                                        <div class="space-y-4">
                                            <!-- Payment Amount -->
                                            <div>
                                                <label for="paymentAmount" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wider">Amount (₹)</label>
                                                <div class="mt-1 relative rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                                    </div>
                                                    <input type="number" wire:model="paymentAmount" id="paymentAmount"
                                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 py-2 sm:text-sm border-gray-300 rounded-md"
                                                        placeholder="0.00">
                                                </div>
                                            </div>



                                            <!-- Payment Reference -->
                                            <div>
                                                <label for="paymentReference" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wider">Reference/Note</label>
                                                <input type="text" wire:model="paymentReference" id="paymentReference"
                                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full py-2 px-3 sm:text-sm border-gray-300 rounded-md"
                                                    placeholder="Enter payment reference">
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex space-x-3 pt-2">
                                                <button type="button" wire:click="completeWithPayment"
                                                    class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition duration-150 ease-in-out">
                                                    Submit Task
                                                </button>
                                                <button type="button" wire:click="cancelPayment"
                                                    class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium transition duration-150 ease-in-out">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Status Selector -->
                                <div>
                                    <label for="status" class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wider">Update Status</label>
                                    <div class="mt-1 relative">
                                        <select id="status" wire:model="selectedStatus" wire:change="updateStatus"
                                            class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @foreach ($statusOptions as $value => $label)
                                                @if ($value != 90)
                                                    <option value="{{ $value }}" @if ($value == $task->status) selected @endif>
                                                        {{ $label }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fas fa-chevron-down text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            @elseif($taskRejected)
                                <!-- Show rejected message -->
                                <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-times-circle text-red-500 text-xl mt-1"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg  text-red-800">Task Rejected</h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <p class="flex items-center">
                                                    <i class="far fa-calendar-times mr-1.5"></i>
                                                    Rejected on: {{ $task->updated_at->format('M d, Y h:i A') }}
                                                </p>
                                                @if($task->remark)
                                                    <p class="mt-2 flex items-start">
                                                        <i class="fas fa-comment-alt mr-1.5 mt-1"></i>
                                                        <span>Reason: {{ $task->remark }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Show payment completed message -->
                                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg  text-green-800">Task Completed</h3>
                                            <div class="mt-2 text-sm text-green-700">
                                                <p class="flex items-center">
                                                    <i class="far fa-calendar-check mr-1.5"></i>
                                                    Completed on: {{ $task->updated_at->format('M d, Y h:i A') }}
                                                </p>
                                                @if($task->payments->isNotEmpty())
                                                    <p class="mt-2 flex items-center">
                                                        <i class="fas fa-rupee-sign mr-1.5"></i>
                                                        <span>Payment: ₹{{ number_format($task->payments->first()->total_amount, 2) }}</span>
                                                    </p>
                                                    <p class="mt-1 flex items-center">
                                                        <i class="fas fa-info-circle mr-1.5"></i>
                                                        <span>Status: 
                                                            <span class="px-2 inline-flex text-xs leading-5  rounded-full 
                                                                @if($task->payments->first()->status === 'completed') bg-green-100 text-green-800
                                                                @elseif($task->payments->first()->status === 'pending') bg-yellow-100 text-yellow-800
                                                                @else bg-red-100 text-red-800 @endif">
                                                                {{ ucfirst($task->payments->first()->status) }}
                                                            </span>
                                                        </span>
                                                    </p>
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
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-100">
                                <h2 class="text-lg  text-gray-800 flex items-center">
                                    <i class="fas fa-receipt text-green-600 mr-3"></i>
                                    Payment History
                                </h2>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach ($task->payments as $payment)
                                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class=" text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</span>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                            @if($payment->payment_method === 'cash') bg-blue-100 text-blue-800
                                                            @elseif($payment->payment_method === 'card') bg-purple-100 text-purple-800
                                                            @elseif($payment->payment_method === 'online') bg-teal-100 text-teal-800
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            <i class="fas 
                                                                @if($payment->payment_method === 'cash') fa-money-bill-wave 
                                                                @elseif($payment->payment_method === 'card') fa-credit-card 
                                                                @elseif($payment->payment_method === 'online') fa-globe 
                                                                @else fa-question-circle @endif 
                                                                mr-1 text-xs"></i>
                                                            {{ ucfirst($payment->payment_method) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y') }}</span>
                                                    <div class="mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                            @if($payment->status === 'completed') bg-green-100 text-green-800
                                                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($payment->notes)
                                                <div class="mt-2 text-xs text-gray-600 bg-gray-50 p-2 rounded">
                                                    <i class="far fa-sticky-note mr-1"></i> {{ $payment->notes }}
                                                </div>
                                            @endif
                                            @if ($payment->receiver)
                                                <div class="mt-2 text-xs text-gray-500">
                                                    <i class="fas fa-user-tie mr-1"></i> Processed by: {{ $payment->receiver->name }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Reason Modal -->
    @if($showRejectionModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Reject Service Request
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Please provide a detailed reason for rejecting this service request. This information will be shared with the customer.
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <textarea wire:model="rejectionReason" rows="4" class="shadow-sm border p-2 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter rejection reason..."></textarea>
                                    @error('rejectionReason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="confirmRejection" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm Rejection
                        </button>
                        <button wire:click="$set('showRejectionModal', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000,
                extendedTimeOut: 1000,
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut',
            });
            if (event.type === 'success') {
                Livewire.emit('taskUpdated');
            }
            if (event.type === 'error') {
                Livewire.emit('taskError');
            }
            if (event.type === 'info') {
                Livewire.emit('taskInfo');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        Livewire.on('taskUpdated', () => {
            toastr.success('Task updated successfully!', 'Success');
        });

        Livewire.on('taskError', () => {
            toastr.error('An error occurred while updating the task.', 'Error');
        });

        Livewire.on('taskInfo', () => {
            toastr.info('Please check the task details.', 'Info');
        });
    });
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        document.querySelector('.sidebar-toggle').addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        });
    });
</script>
@endpush
</div>