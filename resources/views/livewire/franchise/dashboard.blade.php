<main class="p-4 sm:p-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="card stat-card bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-store text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Receptionists</p>
                    <h3 class="text-2xl font-bold">{{ $stats['totalReceptionists'] }}</h3>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-green-500 font-medium">
                    <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                </p>
            </div>
        </div>

        <div class="card stat-card bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Customers</p>
                    <h3 class="text-2xl font-bold">{{ number_format($stats['totalCustomers']) }}</h3>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-green-500 font-medium">
                    <i class="fas fa-arrow-up mr-1"></i> 5% from last month
                </p>
            </div>
        </div>

        <div class="card stat-card bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-wrench text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Services Completed</p>
                    <h3 class="text-2xl font-bold">{{ number_format($stats['servicesCompleted']) }}</h3>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-red-500 font-medium">
                    <i class="fas fa-arrow-down mr-1"></i> 8% from last month
                </p>
            </div>
        </div>

        <div class="card stat-card bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <i class="fas fa-file-invoice-dollar text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Revenue</p>
                    <h3 class="text-2xl font-bold">₹
                        @php
                            $revenue = $stats['totalRevenue'];
                            if ($revenue >= 10000000) {
                                // 1 crore or more
                                echo number_format($revenue / 10000000, 1) . ' million';
                            } elseif ($revenue >= 100000) {
                                // 1 lakh or more
                                echo number_format($revenue / 100000, 1) . ' lakh';
                            } elseif ($revenue >= 1000) {
                                // 1 thousand or more
                                echo number_format($revenue / 1000, 1) . 'k';
                            } else {
                                echo number_format($revenue, 2);
                            }
                        @endphp
                    </h3>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-green-500 font-medium">
                    <i class="fas fa-arrow-up mr-1"></i> 22% from last month
                </p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6">
        <div class="card bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Revenue Growth</h2>
                <div class="flex">
                    <button wire:click="updateTimeRange('monthly')"
                        class="px-3 py-1 text-sm {{ $timeRange === 'monthly' ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100' }} rounded mr-2">
                        Monthly
                    </button>
                    <button wire:click="updateTimeRange('yearly')"
                        class="px-3 py-1 text-sm {{ $timeRange === 'yearly' ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100' }} rounded">
                        Yearly
                    </button>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="revenueChart" wire:ignore x-data="{
                    init() {
                        const ctx = this.$el.getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: @js($revenueData['labels']),
                                datasets: [{
                                    label: 'Revenue ($)',
                                    data: @js($revenueData['values']),
                                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    borderWidth: 2,
                                    tension: 0.1,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                
                        Livewire.on('timeRangeUpdated', () => {
                            chart.data.labels = @js($revenueData['labels']);
                            chart.data.datasets[0].data = @js($revenueData['values']);
                            chart.update();
                        });
                    }
                }"></canvas>
            </div>
        </div>

        <div class="card bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Service Performance</h2>
                <select wire:model="performanceFilter" wire:change="updatePerformanceFilter($event.target.value)"
                    class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>Top Performing</option>
                    <option>Mid Performing</option>
                    <option>Low Performing</option>
                </select>
            </div>
            <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="performanceChart" wire:ignore x-data="{
                    init() {
                        const ctx = this.$el.getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: @js($performanceData['labels']),
                                datasets: [{
                                    label: 'Revenue ($)',
                                    data: @js($performanceData['values']),
                                    backgroundColor: [
                                        'rgba(124, 58, 237, 0.7)',
                                        'rgba(124, 58, 237, 0.6)',
                                        'rgba(124, 58, 237, 0.5)',
                                        'rgba(124, 58, 237, 0.4)',
                                        'rgba(124, 58, 237, 0.3)',
                                    ],
                                    borderColor: 'rgba(124, 58, 237, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                
                        Livewire.on('performanceFilterUpdated', () => {
                            chart.data.labels = @js($performanceData['labels']);
                            chart.data.datasets[0].data = @js($performanceData['values']);
                            chart.update();
                        });
                    }
                }"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="card bg-white rounded-lg shadow p-4 sm:p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Recent Orders</h2>
                <a href="" class="text-sm text-blue-600 hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $order['id'] }}</td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order['customer'] }}</td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order['service'] }}</td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $order['status']['class'] }}">{{ $order['status']['text'] }}</span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($order['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card bg-white rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
            <div class="space-y-3 sm:space-y-4">
                <a wire:navigate href="{{ route('franchise.add.staff') }}"
                    class="block w-full flex items-center justify-between p-3 sm:p-4 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                    <span>Add New Staff</span>
                    <i class="fas fa-user-plus"></i>
                </a>
                <a href=""
                    class="block w-full flex items-center justify-between p-3 sm:p-4 bg-green-50 text-green-600 rounded-lg hover:bg-green-100">
                    <span>Create Invoice</span>
                    <i class="fas fa-file-invoice"></i>
                </a>
                <a href=""
                    class="block w-full flex items-center justify-between p-3 sm:p-4 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100">
                    <span>Schedule Service</span>
                    <i class="fas fa-calendar-alt"></i>
                </a>
                <a href=""
                    class="block w-full flex items-center justify-between p-3 sm:p-4 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-100">
                    <span>Generate Report</span>
                    <i class="fas fa-chart-pie"></i>
                </a>
            </div>

            <div class="mt-6 sm:mt-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Notifications</h2>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-full mr-3">
                            <i class="fas fa-info-circle text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">New service request received</p>
                            <p class="text-xs text-gray-500">5 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="p-2 bg-green-100 text-green-600 rounded-full mr-3">
                            <i class="fas fa-check-circle text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Monthly maintenance completed</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="p-2 bg-red-100 text-red-600 rounded-full mr-3">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Critical component needs replacement</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
