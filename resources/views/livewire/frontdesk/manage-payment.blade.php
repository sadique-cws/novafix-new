<div class="max-w-7xl mx-auto py-4 sm:py-6 px-3 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-blue-700 tracking-tight">Manage Payments</h2>
            <p class="text-sm sm:text-base text-gray-500 mt-1">View and manage all service payments</p>
        </div>
    </div>
    
    <!-- Filters Section -->
    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Search -->
            <div class="sm:col-span-2">
                <label for="search" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="search"
                        class="block w-full pl-9 pr-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search by service code or customer...">
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" id="status"
                    class="block w-full pl-3 pr-8 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Method Filter -->
            <div>
                <label for="method" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Method</label>
                <select wire:model.live="methodFilter" id="method"
                    class="block w-full pl-3 pr-8 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Methods</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="upi">UPI</option>
                    <option value="net_banking">Net Banking</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 sm:gap-4 mt-4">
            <!-- Date Filter -->
            <div class="sm:col-span-1">
                <label for="date" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Date</label>
                <input wire:model.live="dateFilter" type="date" id="date"
                    class="block w-full pl-3 pr-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Reset Button -->
            <div class="sm:col-span-3 flex items-end">
                <button wire:click="resetFilters"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center justify-center text-xs sm:text-sm">
                    <i class="fas fa-sync-alt mr-2 text-xs"></i> Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <!-- Total Payments Card -->
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border-t-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-semibold text-gray-500">Total Payments</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-blue-700 mt-1">₹{{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="p-2 sm:p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-credit-card text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Completed Card -->
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border-t-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-semibold text-gray-500">Completed</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-green-700 mt-1">{{ $completedCount }}</p>
                </div>
                <div class="p-2 sm:p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Card -->
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border-t-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-semibold text-gray-500">Pending</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-yellow-700 mt-1">{{ $pendingCount }}</p>
                </div>
                <div class="p-2 sm:p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-hourglass-half text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        @if ($payments->isEmpty())
            <div class="p-6 sm:p-8 text-center">
                <i class="fas fa-receipt text-3xl sm:text-4xl text-gray-300 mb-3"></i>
                <h3 class="text-sm sm:text-base font-medium text-gray-500">No payments found</h3>
                <p class="text-xs sm:text-sm text-gray-400 mt-1">Try adjusting your search or filter criteria</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-2 sm:px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Service Code</th>
                            <th class="px-2 sm:px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Customer</th>
                            <th class="px-2 sm:px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Amount</th>
                            <th class="px-2 sm:px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status</th>
                            <th class="hidden sm:table-cell px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Method</th>
                            <th class="hidden md:table-cell px-3 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Date</th>
                            <th class="px-2 sm:px-3 py-3 text-center text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <!-- Service Code -->
                                <td class="px-2 sm:px-3 py-3 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-semibold text-gray-700">
                                        {{ $payment->service->service_code }}
                                    </div>
                                </td>
                                
                                <!-- Customer -->
                                <td class="px-2 sm:px-3 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-xs sm:text-sm font-medium">{{ $payment->service->owner_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $payment->service->contact_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Amount -->
                                <td class="px-2 sm:px-3 py-3 whitespace-nowrap text-blue-700 font-bold text-xs sm:text-sm">
                                    ₹{{ number_format($payment->total_amount, 2) }}
                                </td>
                                
                                <!-- Status -->
                                <td class="px-2 sm:px-3 py-3 whitespace-nowrap">
                                    @if ($payment->status === 'completed')
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i> <span class="hidden sm:inline">Completed</span>
                                        </span>
                                    @elseif ($payment->status === 'pending')
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-hourglass-half mr-1 text-xs"></i> <span class="hidden sm:inline">Pending</span>
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1 text-xs"></i> <span class="hidden sm:inline">Cancelled</span>
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Method (hidden on small screens) -->
                                <td class="hidden sm:table-cell px-3 py-3 whitespace-nowrap">
                                    <div class="flex items-center text-xs sm:text-sm">
                                        @switch($payment->payment_method)
                                            @case('cash') <i class="fas fa-money-bill-wave mr-2 text-green-500"></i> @break
                                            @case('credit_card') <i class="fas fa-credit-card mr-2 text-blue-500"></i> @break
                                            @case('debit_card') <i class="fas fa-credit-card mr-2 text-purple-500"></i> @break
                                            @case('upi') <i class="fas fa-mobile-alt mr-2 text-indigo-500"></i> @break
                                            @case('net_banking') <i class="fas fa-university mr-2 text-teal-500"></i> @break
                                            @default <i class="fas fa-wallet mr-2 text-gray-500"></i>
                                        @endswitch
                                        <span class="hidden md:inline">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                        <span class="md:hidden">{{ ucfirst(substr(str_replace('_', ' ', $payment->payment_method), 0, 4) )}}</span>
                                    </div>
                                </td>
                                
                                <!-- Date (hidden on medium screens) -->
                                <td class="hidden md:table-cell px-3 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                    {{ $payment->created_at->format('d M Y, h:i A') }}
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-2 sm:px-3 py-3 whitespace-nowrap">
                                    <div class="flex justify-center space-x-1 sm:space-x-2">
                                        <a wire:navigate
                                            href="{{ route('frontdesk.payment-details', $payment->serviceRequest->service_code) }}"
                                            class="text-xs sm:text-sm rounded bg-blue-500 text-white px-2 sm:px-3 py-1 hover:bg-blue-600 transition flex items-center">
                                            <i class="fas fa-eye mr-1 text-xs"></i>
                                            <span class="hidden xs:inline">View</span>
                                        </a>
                                        <button
                                            class="text-xs sm:text-sm rounded bg-red-500 text-white px-2 sm:px-3 py-1 hover:bg-red-600 transition flex items-center">
                                            <i class="fas fa-trash-alt mr-1 text-xs"></i>
                                            <span class="hidden xs:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>