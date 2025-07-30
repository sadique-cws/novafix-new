<div class="max-w-7xl mx-auto  sm:py-6 px-3 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col space-y-3 mb-6">
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-blue-700 tracking-tight">Manage Payments</h2>
        <p class="text-xs sm:text-sm text-gray-500">View and manage all service payments</p>
    </div>
    
    <!-- Filters Section -->
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="search"
                        class="block w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="Service code or customer...">
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" id="status"
                    class="block w-full pl-3 pr-8 py-3 text-sm border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <option value="all">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="mt-3 sm:mt-0 sm:col-span-2">
                <button wire:click="resetFilters"
                    class="w-full sm:w-auto px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center justify-center text-sm font-medium">
                    <i class="fas fa-sync-alt mr-2 text-xs"></i> Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- Total Payments Card -->
        <div class="bg-white p-4 rounded-2xl shadow-lg border-t-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500">Total Payments</p>
                    <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-blue-700 mt-1">₹{{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-credit-card text-base sm:text-lg"></i>
                </div>
            </div>
        </div>
        
        <!-- Completed Card -->
        <div class="bg-white p-4 rounded-2xl shadow-lg border-t-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500">Completed</p>
                    <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-green-700 mt-1">{{ $completedCount }}</p>
                </div>
                <div class="p-2 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-base sm:text-lg"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Card -->
        <div class="bg-white p-4 rounded-2xl shadow-lg border-t-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500">Pending</p>
                    <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-yellow-700 mt-1">{{ $pendingCount }}</p>
                </div>
                <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-hourglass-half text-base sm:text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        @if ($payments->isEmpty())
            <div class="p-6 text-center">
                <i class="fas fa-receipt text-3xl text-gray-300 mb-3"></i>
                <h3 class="text-sm font-medium text-gray-500">No payments found</h3>
                <p class="text-xs text-gray-400 mt-1">Try adjusting your search or filter criteria</p>
            </div>
        @else
            <!-- Desktop/Tablet Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Service Code</th>
                            <th class="px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Customer</th>
                            <th class="px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Amount</th>
                            <th class="px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status</th>
                            <th class="px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Method</th>
                            <th class="px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Date</th>
                            <th class="px-3 py-3 text-center text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <!-- Service Code -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-700">
                                        {{ $payment->service->service_code }}
                                    </div>
                                </td>
                                
                                <!-- Customer -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium">{{ $payment->service->owner_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $payment->service->contact_number }}</div>
                                        </div>
                                    </div>
                                </td>
                        
                                <!-- Amount -->
                                <td class="px-3 py-3 whitespace-nowrap text-blue-700 font-bold text-sm">
                                    ₹{{ number_format($payment->total_amount, 2) }}
                                </td>
                                
                                <!-- Status -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if ($payment->status === 'completed')
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i> Completed
                                        </span>
                                    @elseif ($payment->status === 'pending')
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-hourglass-half mr-1 text-xs"></i> Pending
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1 text-xs"></i> Cancelled
                                        </span>
                                    @endif
                                </td>
                                <!-- Method -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="flex items-center text-sm">
                                        @switch($payment->payment_method)
                                            @case('cash') <i class="fas fa-money-bill-wave mr-2 text-green-500"></i> @break
                                            @case('credit_card') <i class="fas fa-credit-card mr-2 text-blue-500"></i> @break
                                            @case('debit_card') <i class="fas fa-credit-card mr-2 text-purple-500"></i> @break
                                            @case('upi') <i class="fas fa-mobile-alt mr-2 text-indigo-500"></i> @break
                                            @case('net_banking') <i class="fas fa-university mr-2 text-teal-500"></i> @break
                                            @default <i class="fas fa-wallet mr-2 text-gray-500"></i>
                                        @endswitch
                                        {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                                    </div>
                                </td>
                                <!-- Date -->
                                <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->created_at->format('d M Y, h:i A') }}
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="flex justify-center space-x-2">
                                        <a wire:navigate
                                            href="{{ route('frontdesk.payment-details', $payment->serviceRequest->service_code) }}"
                                            class="text-sm rounded bg-blue-500 text-white px-3 py-1 hover:bg-blue-600 transition flex items-center">
                                            <i class="fas fa-eye mr-1 text-xs"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Mobile/Tablet Card View -->
            <div class="md:hidden space-y-4 p-4">
                @foreach ($payments as $payment)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                        <div class="grid grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-500">Service Code</p>
                                <p class="text-sm font-medium text-gray-700">{{ $payment->service->service_code }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500">Amount</p>
                                <p class="text-sm font-bold text-blue-700">₹{{ number_format($payment->total_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500">Customer</p>
                                <p class="text-sm font-medium">{{ $payment->service->owner_name }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->service->contact_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500">Status</p>
                                @if ($payment->status === 'completed')
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Completed
                                    </span>
                                @elseif ($payment->status === 'pending')
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hourglass-half mr-1"></i> Pending
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Cancelled
                                    </span>
                                @endif
                            </div>
                            <!-- Method and Date for Tablets -->
                            <div class="hidden sm:block">
                                <p class="text-xs font-semibold text-gray-500">Method</p>
                                <div class="flex items-center text-sm">
                                    @switch($payment->payment_method)
                                        @case('cash') <i class="fas fa-money-bill-wave mr-2 text-green-500"></i> @break
                                        @case('credit_card') <i class="fas fa-credit-card mr-2 text-blue-500"></i> @break
                                        @case('debit_card') <i class="fas fa-credit-card mr-2 text-purple-500"></i> @break
                                        @case('upi') <i class="fas fa-mobile-alt mr-2 text-indigo-500"></i> @break
                                        @case('net_banking') <i class="fas fa-university mr-2 text-teal-500"></i> @break
                                        @default <i class="fas fa-wallet mr-2 text-gray-500"></i>
                                    @endswitch
                                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                                </div>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-xs font-semibold text-gray-500">Date</p>
                                <p class="text-sm text-gray-500">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-end space-x-2">
                            <a wire:navigate
                                href="{{ route('frontdesk.payment-details', $payment->serviceRequest->service_code) }}"
                                class="text-xs rounded bg-blue-500 text-white px-3 py-1.5 hover:bg-blue-600 transition flex items-center">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                            
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>