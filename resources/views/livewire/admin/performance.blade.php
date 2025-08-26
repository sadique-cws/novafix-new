<div x-data="{ 
    loading: false,
    init() {
        // Listen for Livewire events
        Livewire.on('loading', () => { this.loading = true });
        Livewire.on('loaded', () => { this.loading = false });
        
        // Set up loading state for Livewire updates
        document.addEventListener('livewire:init', () => {
            Livewire.on('loading', () => { this.loading = true });
            Livewire.on('loaded', () => { this.loading = false });
        });
    }
}" class="relative">
    <!-- Loading Overlay -->
    <template x-if="loading">
        <div class="fixed inset-0 bg-white bg-opacity-90 z-50 flex items-center justify-center transition-opacity duration-200">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600 mb-4"></div>
                <h3 class="text-lg font-semibold text-gray-800">Loading Franchise Data</h3>
                <p class="text-gray-600 mt-1">Please wait while we fetch the performance metrics</p>
            </div>
        </div>
    </template>

    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-8">
        <!-- Header with franchise selector -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Franchise Performance</h2>
                <p class="text-sm text-gray-500 mt-1">Detailed analytics for selected franchise</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative w-full">
                    <select wire:model.live="selectedFranchise"
                        class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg bg-gray-50 transition">
                        <option value="all">All Franchises</option>
                        @foreach ($franchises as $franchise)
                            <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative w-full">
                    <select wire:model.live="timePeriod"
                        class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg bg-gray-50 transition">
                        <option value="7days">Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
                        <option value="90days">Last 90 Days</option>
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Key Performance Indicators - 2x2 grid on mobile -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-8">
            <!-- Revenue Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                <div class="flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-blue-800">Total Revenue</p>
                            <p class="text-xl sm:text-2xl font-semibold text-gray-800 mt-1">
                                ₹
                                @if ($metrics['totalRevenue'] >= 10000000)
                                    {{ number_format($metrics['totalRevenue'] / 10000000, 1) }} Cr
                                @elseif($metrics['totalRevenue'] >= 100000)
                                    {{ number_format($metrics['totalRevenue'] / 100000, 1) }} L
                                @elseif($metrics['totalRevenue'] >= 1000)
                                    {{ number_format($metrics['totalRevenue'] / 1000, 1) }}k
                                @else
                                    {{ number_format($metrics['totalRevenue'], 2) }}
                                @endif
                            </p>
                        </div>
                        <div class="bg-blue-200/50 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                <div class="flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-green-800">Customers</p>
                            <p class="text-xl sm:text-2xl font-semibold text-gray-800 mt-1">{{ $metrics['totalCustomers'] }}</p>
                        </div>
                        <div class="bg-green-200/50 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                <div class="flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-purple-800">Services</p>
                            <p class="text-xl sm:text-2xl font-semibold text-gray-800 mt-1">{{ $metrics['completedServices'] }}</p>
                        </div>
                        <div class="bg-purple-200/50 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retention Card -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 rounded-xl border border-amber-200">
                <div class="flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs sm:text-sm font-medium text-amber-800">Retention Rate</p>
                            <p class="text-xl sm:text-2xl font-semibold text-gray-800 mt-1">{{ $metrics['customerRetention']['retentionRate'] }}%</p>
                        </div>
                        <div class="bg-amber-200/50 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Retention Details -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-3">Customer Retention Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <p class="text-2xl font-bold text-blue-600">{{ $metrics['customerRetention']['newCustomers'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">New Customers</p>
                </div>
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <p class="text-2xl font-bold text-green-600">{{ $metrics['customerRetention']['returningCustomers'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">Returning Customers</p>
                </div>
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <p class="text-2xl font-bold text-purple-600">{{ $metrics['customerRetention']['retentionRate'] }}%</p>
                    <p class="text-sm text-gray-600 mt-1">Retention Rate</p>
                </div>
            </div>
        </div>

        <!-- Payment Details Section -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-800">Payment Transactions</h3>
                <div class="flex flex-col sm:flex-row gap-3 mt-2 md:mt-0">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="paymentSearch"
                            placeholder="Search payments..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select wire:model.live="paymentStatus"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transaction ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $payment->transaction_id ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->serviceRequest->owner_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->serviceRequest->serviceCategory->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ₹{{ number_format($payment->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass =
                                            [
                                                'completed' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                            ][$payment->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="text-sm text-gray-500">
                    Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }}
                    payments
                </div>
                <div class="flex space-x-2">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Activities</h3>
            <div class="space-y-3">
                @foreach ($activities as $activity)
                    <div class="flex items-start">
                        <div class="bg-{{ $activity['color'] }}-100 p-2 rounded-full mr-3">
                            <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>