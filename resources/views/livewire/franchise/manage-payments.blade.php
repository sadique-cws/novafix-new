<div class="space-y-6">
    <!-- Actions and Filters Toggle -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-end gap-3 mb-4">
        <x-ui.button wire:click="exportPayments" variant="secondary">
            <i class="fas fa-file-export mr-2"></i> Export
        </x-ui.button>
        <x-ui.button wire:click="$toggle('showFilters')" variant="{{ $showFilters ? 'primary' : 'secondary' }}">
            <i class="fas fa-filter mr-2"></i> Filters
        </x-ui.button>
    </div>

    <!-- Filter Section -->
    @if($showFilters)
    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Search</label>
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, code..." />
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status</label>
                <x-ui.select wire:model.live="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </x-ui.select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Payment Method</label>
                <x-ui.select wire:model.live="paymentMethodFilter">
                    <option value="">All Methods</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="upi">UPI</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </x-ui.select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date Range</label>
                <div class="flex space-x-2">
                    <x-ui.input type="date" wire:model.live="startDate" />
                    <x-ui.input type="date" wire:model.live="endDate" />
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button wire:click="resetFilters" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">Reset Filters</button>
        </div>
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6 border-l-4 border-l-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Payments</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($totalAmount, 2) }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6 border-l-4 border-l-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Today's Collection</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($todayAmount, 2) }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6 border-l-4 border-l-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Completed</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $payments->where('status', 'completed')->count() }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('serviceRequest.service_code')">
                    Service Code
                    @if($sortField === 'serviceRequest.service_code')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('serviceRequest.owner_name')">
                    Customer
                    @if($sortField === 'serviceRequest.owner_name')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('total_amount')">
                    Amount
                    @if($sortField === 'total_amount')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">
                    Method
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('status')">
                    Status
                    @if($sortField === 'status')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('created_at')">
                    Date
                    @if($sortField === 'created_at')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">
                    Actions
                </th>
            </x-slot>

            @forelse($payments as $payment)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    <td class="px-5 py-4 text-sm font-medium text-gray-900">
                        {{ $payment->serviceRequest->service_code }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $payment->serviceRequest->owner_name }}</div>
                        <div class="text-sm text-gray-500">{{ $payment->serviceRequest->contact }}</div>
                    </td>
                    <td class="px-5 py-4 text-sm font-bold text-blue-600">
                        ₹{{ number_format($payment->total_amount, 2) }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
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
                    <td class="px-5 py-4">
                        @if ($payment->status === 'completed')
                            <x-ui.badge color="green">Completed</x-ui.badge>
                        @elseif ($payment->status === 'pending')
                            <x-ui.badge color="yellow">Pending</x-ui.badge>
                        @elseif ($payment->status === 'failed')
                            <x-ui.badge color="red">Failed</x-ui.badge>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        {{ $payment->created_at->format('d M Y, h:i A') }}
                    </td>
                    <td class="px-5 py-4 text-sm text-right font-medium">
                        <div class="flex justify-end space-x-3">
                            <a wire:navigate href="{{ route('franchise.payments.view', $payment->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="View">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-4">
                            <i class="fas fa-receipt text-4xl mb-4 text-gray-300 block"></i>
                            <p class="text-lg font-medium text-gray-900">No payments found</p>
                            <p class="text-sm mt-1">Try adjusting your search or filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
        
        @if($payments->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>