<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Receptionists -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-tie"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Receptionists</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ $stats['totalReceptionists'] }}</h3>
        </div>

        <!-- Total Customers -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fas fa-users"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Customers</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['totalCustomers']) }}</h3>
        </div>

        <!-- Services Completed -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fas fa-wrench"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Services Completed</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['servicesCompleted']) }}</h3>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">₹
                @php
                    $revenue = $stats['totalRevenue'];
                    if ($revenue >= 10000000) {
                        echo number_format($revenue / 10000000, 1) . 'Cr';
                    } elseif ($revenue >= 100000) {
                        echo number_format($revenue / 100000, 1) . 'L';
                    } elseif ($revenue >= 1000) {
                        echo number_format($revenue / 1000, 1) . 'K';
                    } else {
                        echo number_format($revenue, 2);
                    }
                @endphp
            </h3>
        </div>
    </div>

    <!-- Recent Orders + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Recent Orders</h2>
                <a href="" class="text-sm font-medium text-primary hover:text-primary/80">View All</a>
            </div>

            <div class="overflow-x-auto">
                <x-ui.table>
                    <x-slot name="head">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Order ID</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Customer</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Service</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Amount</th>
                    </x-slot>
                    
                    @forelse ($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                            <td class="px-5 py-3 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order['id'] }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order['customer'] }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order['service'] }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">
                                @php
                                    $color = 'gray';
                                    if(str_contains(strtolower($order['status']['text']), 'pend')) $color = 'blue';
                                    if(str_contains(strtolower($order['status']['text']), 'progress') || str_contains(strtolower($order['status']['text']), 'process')) $color = 'yellow';
                                    if(str_contains(strtolower($order['status']['text']), 'comple')) $color = 'green';
                                    if(str_contains(strtolower($order['status']['text']), 'reject')) $color = 'red';
                                @endphp
                                <x-ui.badge :color="$color">{{ $order['status']['text'] }}</x-ui.badge>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm font-medium text-green-600">₹{{ number_format($order['amount'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">No recent orders found.</td>
                        </tr>
                    @endforelse
                </x-ui.table>
            </div>
        </div>

        <!-- Quick Actions + Notifications -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Quick Actions</h2>
            </div>
            <div class="p-4 space-y-2">
                <a wire:navigate href="{{ route('franchise.add.staff') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Add New Staff</p>
                        <p class="text-xs text-gray-500 mt-0.5">Register a new technician</p>
                    </div>
                </a>
                
                <a wire:navigate href="{{route('franchise.add.receptioners')}}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-100 transition-colors">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Add Receptionist</p>
                        <p class="text-xs text-gray-500 mt-0.5">Register a frontdesk user</p>
                    </div>
                </a>
                
                <a wire:navigate href="{{ route('franchise.manage.payments') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Manage Payments</p>
                        <p class="text-xs text-gray-500 mt-0.5">View and record transactions</p>
                    </div>
                </a>
                
                <a wire:navigate href="{{ route('franchise.manage.service') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-100 transition-colors">
                        <i class="fas fa-th-list"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Service Categories</p>
                        <p class="text-xs text-gray-500 mt-0.5">Configure repair types</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>