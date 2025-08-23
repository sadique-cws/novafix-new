<main class="p-4 sm:p-6 bg-[#F9FAFB] text-[#111827]">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid grid-col-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
        
        <!-- Total Receptionists -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#3B82F6]/20 text-[#1E40AF] mr-3">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Receptionists</p>
                    <h3 class="text-xl font-semibold">{{ $stats['totalReceptionists'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#10B981]/20 text-[#10B981] mr-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Customers</p>
                    <h3 class="text-xl font-semibold">{{ number_format($stats['totalCustomers']) }}</h3>
                </div>
            </div>
        </div>

        <!-- Services Completed -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#1E40AF]/20 text-[#1E40AF] mr-3">
                    <i class="fas fa-wrench"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Services Completed</p>
                    <h3 class="text-xl font-semibold">{{ number_format($stats['servicesCompleted']) }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#3B82F6]/20 text-[#3B82F6] mr-3">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <h3 class="text-xl font-semibold">₹
                        @php
                            $revenue = $stats['totalRevenue'];
                            if ($revenue >= 10000000) {
                                echo number_format($revenue / 10000000, 1) . ' Cr';
                            } elseif ($revenue >= 100000) {
                                echo number_format($revenue / 100000, 1) . ' L';
                            } elseif ($revenue >= 1000) {
                                echo number_format($revenue / 1000, 1) . 'K';
                            } else {
                                echo number_format($revenue, 2);
                            }
                        @endphp
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders + Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm lg:col-span-2">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <h2 class="text-lg font-semibold">Recent Orders</h2>
                <a href="" class="text-sm text-[#1E40AF] hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-t border-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-500">Order ID</th>
                            <th class="px-4 py-2 text-left text-gray-500">Customer</th>
                            <th class="px-4 py-2 text-left text-gray-500">Service</th>
                            <th class="px-4 py-2 text-left text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-gray-500">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td class="px-4 py-2">{{ $order['id'] }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ $order['customer'] }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ $order['service'] }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $order['status']['class'] }}">
                                        {{ $order['status']['text'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-gray-600">₹{{ number_format($order['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions + Notifications -->
        <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a wire:navigate href="{{ route('franchise.add.staff') }}"
                   class="block p-3 bg-[#3B82F6]/10 text-[#1E40AF] rounded-lg hover:bg-[#3B82F6]/20 transition">
                    <i class="fas fa-user-tie mr-2"></i>Add New Staff
                </a>
                <a wire:navigate href="{{route('franchise.add.receptioners')}}"
                   class="block p-3 bg-[#10B981]/10 text-[#10B981] rounded-lg hover:bg-[#10B981]/20 transition">
                    <i class="fas fa-concierge-bell mr-2"></i>Add New Receptionist
                </a>
                <a wire:navigate href="{{ route('franchise.manage.payments') }}"
                   class="block p-3 bg-[#1E40AF]/10 text-[#1E40AF] rounded-lg hover:bg-[#1E40AF]/20 transition">
                    <i class="fas fa-money-check-alt mr-2"></i>Manage Payments
                </a>
                <a wire:navigate href=""{{ route('franchise.manage.service') }}""
                   class="block p-3 bg-[#3B82F6]/10 text-[#3B82F6] rounded-lg hover:bg-[#3B82F6]/20 transition">
                    <i class="fas fa-th-list mr-2"></i>Manage Service Category
                </a>
            </div>

           
        </div>
    </div>
</main>
