<div class="max-w-7xl mx-auto py-8 px-4 md:px-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-blue-700 tracking-tight drop-shadow">Manage Payments</h2>
            <p class="text-lg text-gray-500 mt-1">View and manage all service payments</p>
        </div>
       
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <div class="md:absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="search"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search by service code or customer...">
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" id="status"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Method Filter -->
            <div>
                <label for="method" class="block text-sm font-medium text-gray-700 mb-1">Method</label>
                <select wire:model.live="methodFilter" id="method"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Methods</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="upi">UPI</option>
                    <option value="net_banking">Net Banking</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
            <!-- Date Filter -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input wire:model.live="dateFilter" type="date" id="date"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Reset Button -->
            <div class="flex items-end">
                <button wire:click="resetFilters"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i> Reset Filters
                </button>
            </div>
        </div>
    </div>


    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-blue-500 hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base font-semibold text-gray-500">Total Payments</p>
                    <p class="text-3xl font-extrabold text-blue-700 mt-1">₹{{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="p-4 rounded-full bg-blue-100 text-blue-600 shadow">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-green-500 hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base font-semibold text-gray-500">Completed</p>
                    <p class="text-3xl font-extrabold text-green-700 mt-1">{{ $completedCount }}</p>
                </div>
                <div class="p-4 rounded-full bg-green-100 text-green-600 shadow">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-yellow-500 hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base font-semibold text-gray-500">Pending</p>
                    <p class="text-3xl font-extrabold text-yellow-700 mt-1">{{ $pendingCount }}</p>
                </div>
                <div class="p-4 rounded-full bg-yellow-100 text-yellow-600 shadow">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Payments Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-x-auto border border-gray-100">
        @if ($payments->isEmpty())
            <div class="p-8 text-center">
                <i class="fas fa-receipt text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-500">No payments found</h3>
                <p class="text-gray-400 mt-1">Try adjusting your search or filter criteria</p>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-2 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Service
                            Code</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                            Customer</th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Amount
                        </th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status
                        </th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Method
                        </th>
                        <th class="px-2 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Date
                        </th>
                        <th class="px-2 py-4 text-center text-xs font-bold text-blue-700 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($payments as $payment)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-3 py-4 whitespace-nowrap font-semibold text-gray-700">
                                {{ $payment->service->service_code }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-gray-600">
                                <div class="flex items-center">
                                    <div class="ml-0">
                                        <div class="font-medium">{{ $payment->service->owner_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->service->contact_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-blue-700 font-bold">
                                ₹{{ number_format($payment->total_amount, 2) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if ($payment->status === 'completed')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Completed
                                    </span>
                                @elseif ($payment->status === 'pending')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hourglass-half mr-1"></i> Pending
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-gray-600">
                                <div class="flex items-center">
                                    @switch($payment->payment_method)
                                        @case('cash')
                                            <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>
                                        @break

                                        @case('credit_card')
                                            <i class="fas fa-credit-card mr-2 text-blue-500"></i>
                                        @break

                                        @case('debit_card')
                                            <i class="fas fa-credit-card mr-2 text-purple-500"></i>
                                        @break

                                        @case('upi')
                                            <i class="fas fa-mobile-alt mr-2 text-indigo-500"></i>
                                        @break

                                        @case('net_banking')
                                            <i class="fas fa-university mr-2 text-teal-500"></i>
                                        @break

                                        @default
                                            <i class="fas fa-wallet mr-2 text-gray-500"></i>
                                    @endswitch
                                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                                </div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-500">
                                {{ $payment->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-2">
                                    <a wire:navigate
                                        href="{{ route('frontdesk.payment-details', $payment->serviceRequest->service_code) }}"
                                        class=" rounded-lg bg-blue-500 text-white px-3 py-1 hover:text-blue-800">
                                        View
                                    </a>
                                    <button
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition text-xs font-semibold flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
