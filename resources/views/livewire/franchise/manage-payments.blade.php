<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Payment Management</h2>
            <p class="text-gray-600">View and manage all payment transactions</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <button wire:click="exportPayments" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                <i class="fas fa-file-export mr-2"></i> Export
            </button>
            <button wire:click="$toggle('showFilters')" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-filter mr-2"></i> Filters
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    @if($showFilters)
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" wire:model.live.debounce.300ms="search" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="Search by name, code...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select wire:model.live="paymentMethodFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Methods</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="upi">UPI</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            
        </div>
        <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <div class="flex space-x-2">
                    <input type="date" wire:model.live="startDate" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    <input type="date" wire:model.live="endDate" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        <div class="mt-4 flex justify-end">
            <button wire:click="resetFilters" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Reset Filters</button>
        </div>
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Payments</p>
                    <p class="text-2xl font-bold text-blue-600">₹{{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Collection</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($todayAmount, 2) }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Completed Payments</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $payments->where('status', 'completed')->count() }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('serviceRequest.service_code')">
                            Service Code
                            @if($sortField === 'serviceRequest.service_code')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort ml-1 text-gray-300"></i>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('serviceRequest.owner_name')">
                            Customer
                            @if($sortField === 'serviceRequest.owner_name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort ml-1 text-gray-300"></i>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('total_amount')">
                            Amount
                            @if($sortField === 'total_amount')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort ml-1 text-gray-300"></i>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Method
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('status')">
                            Status
                            @if($sortField === 'status')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort ml-1 text-gray-300"></i>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            Date
                            @if($sortField === 'created_at')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @else
                                <i class="fas fa-sort ml-1 text-gray-300"></i>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->serviceRequest->service_code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $payment->serviceRequest->owner_name }}</div>
                            <div class="text-sm text-gray-500">{{ $payment->serviceRequest->contact }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                            ₹{{ number_format($payment->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                @switch($payment->payment_method)
                                    @case('cash')
                                        <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>
                                        @break
                                    @case('credit_card')
                                        <i class="fas fa-credit-card mr-2 text-blue-500"></i>
                                        @break
                                    @case('upi')
                                        <i class="fas fa-mobile-alt mr-2 text-purple-500"></i>
                                        @break
                                    @default
                                        <i class="fas fa-wallet mr-2 text-gray-500"></i>
                                @endswitch
                                {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span @class([
                                'px-2 py-1 text-xs font-semibold rounded-full',
                                'bg-green-100 text-green-800' => $payment->status === 'completed',
                                'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                'bg-red-100 text-red-800' => $payment->status === 'failed',
                            ])>
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payment->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a wire:navigate href="{{route('franchise.payments.view',$payment->id)}}"  
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button wire:click="editPayment({{ $payment->id }})" 
                                    class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $payment->id }})" 
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium text-gray-400">No payments found</p>
                                <p class="text-sm text-gray-400">Try adjusting your search or filters</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $payments->links() }}
        </div>
    </div>
</div>