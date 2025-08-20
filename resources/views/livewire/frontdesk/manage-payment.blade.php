
<div class="max-w-7xl mx-auto pt-4 sm:py-6 px-3 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 mb-6 shadow-lg">
        <div class="flex flex-col space-y-2">
            <h2 class="text-2xl sm:text-3xl  text-white tracking-tight">Manage Payment</h2>
            <p class="text-sm text-blue-100 opacity-90">View and manage all service payments</p>
        </div>
    </div>
    
    <!-- Filters Section -->
    <div class="bg-white/80 backdrop-blur-sm p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Search Payments</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" id="search"
                        class="block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white/50"
                        placeholder="Service code, customer...">
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-xs font-medium text-gray-600 mb-1">Payment Status</label>
                <select wire:model.live="statusFilter" id="status"
                    class="block w-full pl-3 pr-8 py-2.5 text-sm border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white/50">
                    <option value="all">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
        </div>
        
        <!-- Reset Button -->
        <div class="mt-4">
            <button wire:click="resetFilters"
                class="w-full sm:w-auto px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center justify-center text-sm font-medium shadow-sm">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset Filters
            </button>
        </div>
    </div>

    <!-- Mobile Summary Cards - 2x2 Grid -->
    <div class="md:hidden grid grid-cols-2 gap-4 mb-6">
        <!-- Total Payments Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Payments</p>
                    <p class="text-lg  text-blue-600 mt-1">₹{{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                   ₹
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">All time transactions</p>
        </div>
        
        <!-- Completed Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Completed</p>
                    <p class="text-lg  text-green-600 mt-1">{{ $completedCount }}</p>
                </div>
                <div class="p-2 rounded-full bg-green-100 text-green-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $completedPercentage }}% of total</p>
        </div>
        
        <!-- Pending Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Pending</p>
                    <p class="text-lg  text-amber-600 mt-1">{{ $pendingCount }}</p>
                </div>
                <div class="p-2 rounded-full bg-amber-100 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $pendingPercentage }}% of total</p>
        </div>
        
        <!-- Failed Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Failed</p>
                    <p class="text-lg  text-red-600 mt-1">{{ $failedCount }}</p>
                </div>
                <div class="p-2 rounded-full bg-red-100 text-red-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $failedPercentage }}% of total</p>
        </div>
    </div>

    <!-- Desktop Summary Cards -->
    <div class="hidden md:grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Payments Card -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-blue-100 opacity-90">Total Payments</p>
                        <p class="text-2xl  text-white mt-1">₹{{ number_format($totalAmount, 2) }}</p>
                    </div>
                    <div class="p-3 rounded-full text-white  bg-white/20 backdrop-blur-sm">
                        ₹
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-medium text-blue-100">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>All time transactions</span>
                </div>
            </div>
        </div>
        
        <!-- Completed Card -->
        <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-green-100 opacity-90">Completed</p>
                        <p class="text-2xl  text-white mt-1">{{ $completedCount }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xs font-medium text-green-100">{{ $completedPercentage }}% of total</p>
                </div>
            </div>
        </div>
        
        <!-- Pending Card -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-amber-100 opacity-90">Pending</p>
                        <p class="text-2xl  text-white mt-1">{{ $pendingCount }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xs font-medium text-amber-100">{{ $pendingPercentage }}% of total</p>
                </div>
            </div>
        </div>
        
        <!-- Failed Card -->
        <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-red-100 opacity-90">Failed</p>
                        <p class="text-2xl  text-white mt-1">{{ $failedCount }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-white/20 backdrop-blur-sm">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xs font-medium text-red-100">{{ $failedPercentage }}% of total</p>
                </div>
            </div>
        </div>
    </div>

        <!-- Payments Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            @if ($payments->isEmpty())
                <div class="p-8 text-center">
                    <div class="mx-auto h-24 w-24 text-gray-300">
                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mt-4">No payments found</h3>
                    <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filter criteria</p>
                    <button wire:click="resetFilters"
                        class="mt-4 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                        Reset Filters
                    </button>
                </div>
            @else
                <!-- Desktop/Tablet Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Service</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Method</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($payments as $payment)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Service Code -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $payment->service->service_code }}</div>
                                                <div class="text-xs text-gray-500">#{{ $payment->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Customer -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $payment->service->owner_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->service->contact_number }}
                                        </div>
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm  text-blue-600">
                                            ₹{{ number_format($payment->total_amount, 2) }}</div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($payment->status === 'completed')
                                            <span
                                                class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">
                                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-500" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Completed
                                            </span>
                                        @elseif ($payment->status === 'pending')
                                            <span
                                                class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-amber-100 text-amber-800">
                                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-amber-500" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Pending
                                            </span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800">
                                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-500" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Method -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @switch($payment->payment_method)
                                                @case('cash')
                                                    <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('credit_card')
                                                    <div class="flex-shrink-0 h-5 w-5 text-blue-500">
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('debit_card')
                                                    <div class="flex-shrink-0 h-5 w-5 text-purple-500">
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('upi')
                                                    <div class="flex-shrink-0 h-5 w-5 text-indigo-500">
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @case('net_banking')
                                                    <div class="flex-shrink-0 h-5 w-5 text-teal-500">
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                                        </svg>
                                                    </div>
                                                @break

                                                @default
                                                    <div class="flex-shrink-0 h-5 w-5 text-gray-500">
                                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                    </div>
                                            @endswitch
                                            <div class="ml-2 text-sm text-gray-500">
                                                {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>{{ $payment->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $payment->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a wire:navigate
                                                href="{{ route('frontdesk.payment-details', $payment->serviceRequest->service_code) }}"
                                                class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100 transition flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-3 p-4">
                    @foreach ($payments as $payment)
                        <div
                            class="bg-white border border-gray-100 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ $payment->service->service_code }}</h3>
                                            <p class="text-xs text-gray-500">#{{ $payment->id }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-3 grid grid-cols-2 gap-2">
                                        <div>
                                            <p class="text-xs text-gray-500">Customer</p>
                                            <p class="text-sm font-medium">{{ $payment->service->owner_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Amount</p>
                                            <p class="text-sm  text-blue-600">
                                                ₹{{ number_format($payment->total_amount, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Status</p>
                                            @if ($payment->status === 'completed')
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-green-500" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Completed
                                                </span>
                                            @elseif ($payment->status === 'pending')
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-amber-500" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Pending
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-red-500" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Cancelled
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Method</p>
                                            <p class="text-sm text-gray-700">
                                                {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                <div class="text-xs text-gray-500">
                                    {{ $payment->created_at->format('d M Y, h:i A') }}
                                </div>
                                <a wire:navigate
                                    href="{{ route('frontdesk.payment-details', $payment->serviceRequest->service_code) }}"
                                    class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100 transition flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Pagination -->
            @if ($payments->hasPages())
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
