<div>
    <div>
        <!-- Main content area -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50">
            <!-- Dashboard Overview -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 mb-6 text-white">
                <h2 class="text-xl md:text-2xl font-bold mb-2">Dashboard !</h2>
                <p class="opacity-90">Here's what's happening with your franchises today.</p>
            </div>

            <!-- Stats Cards -->
            <!-- Stats Cards - 2x2 on mobile, 4 columns on desktop -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Franchises -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Franchises</p>
                            <p class="text-xl font-bold text-gray-800 mt-1"> {{ $stats['totalFranchises'] }}</p>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span class="font-medium">+{{ round(($stats['totalFranchises'] / 10) * 100) }}%</span>
                                from last month
                            </p>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-store text-blue-600 text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Staff -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Staff</p>
                            <p class="text-xl font-bold text-gray-800 mt-1">{{ $stats['activeStaff'] }}</p>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span class="font-medium">+{{ round(($stats['activeStaff'] / 20) * 100) }}%</span> from
                                last month
                            </p>
                        </div>
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="fas fa-users text-green-600 text-sm"></i>
                        </div>
                    </div>
                </div>
                 <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Receptionists</p>
                            <p class="text-xl font-bold text-gray-800 mt-1">{{ $stats['receptionists'] }}</p>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span class="font-medium">+{{ round(($stats['receptionists'] / 5) * 100) }}%</span> from
                                last month
                            </p>
                        </div>
                        <div class="bg-amber-100 p-2 rounded-full">
                            <i class="fas fa-user-tie text-yellow-600 text-sm"></i>

                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Revenue</p>
                            @php
                                $revenue = $stats['monthlyRevenue'];
                                $formattedRevenue = '';
                                if ($revenue >= 10000000) {
                                    $formattedRevenue = '₹' . number_format($revenue / 10000000, 2) . 'Cr';
                                } elseif ($revenue >= 1000000) {
                                    $formattedRevenue = '₹' . number_format($revenue / 1000000, 2) . 'M';
                                } elseif ($revenue >= 100000) {
                                    $formattedRevenue = '₹' . number_format($revenue / 100000, 2) . 'L';
                                } elseif ($revenue >= 1000) {
                                    $formattedRevenue = '₹' . number_format($revenue / 1000, 2) . 'k';
                                } else {
                                    $formattedRevenue = '₹' . number_format($revenue, 2);
                                }
                            @endphp
                            <p class="text-xl font-bold text-gray-800 mt-1">{{ $formattedRevenue }}</p>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span
                                    class="font-medium">{{ $stats['growthRate'] >= 0 ? '+' : '' }}{{ $stats['growthRate'] }}%</span>
                                from last month
                            </p>
                        </div>
                        <div class="bg-purple-100 p-2 rounded-full">
                            <i class="fas fa-rupee-sign text-purple-600 text-sm"></i>
                        </div>
                    </div>
                </div>

               
            </div>
            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Revenue Chart -->
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800">Revenue Overview</h2>
                        <select
                            class="text-xs sm:text-sm border border-gray-300 rounded px-2 sm:px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option selected>Last 12 Months</option>
                        </select>
                    </div>
                    <div class="chart-container h-64 sm:h-80">
                        <canvas id="revenueChart" wire:ignore></canvas>
                    </div>
                </div>

                <!-- Franchise Performance -->
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800">Top Performing Franchises</h2>
                        <select
                            class="text-xs sm:text-sm border border-gray-300 rounded px-2 sm:px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>By Revenue</option>
                            <option selected>By Growth</option>
                            <option>By Customer Satisfaction</option>
                        </select>
                    </div>
                    <div class="chart-container h-64 sm:h-80">
                        <canvas id="performanceChart" wire:ignore></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Top Franchises -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Recent Activity -->
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm lg:col-span-2">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="space-y-4">
                        @forelse($recentActivities as $activity)
                            <div class="flex items-start">
                                <div class="bg-{{ $activity['color'] }}-100 p-2 sm:p-2.5 rounded-full mr-3">
                                    <i
                                        class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-xs sm:text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">{{ $activity['title'] }}</p>
                                    <p class="text-xs sm:text-sm text-gray-500">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No recent activities</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top Franchises -->
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Top Franchises This Month</h2>
                    <div class="space-y-4">
                        @foreach ($topFranchises as $index => $franchise)
                            <div class="flex items-center">
                                <div
                                    class="w-6 sm:w-8 h-6 sm:h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span
                                        class="text-blue-600 font-medium text-xs sm:text-sm">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">{{ $franchise->franchise_name }}</p>
                                    <p class="text-xs sm:text-sm text-gray-500">
                                        ₹{{ number_format($franchise->revenue ?? 0, 2) }} revenue</p>
                                </div>
                                <span
                                    class="text-green-600 text-xs sm:text-sm font-medium">+{{ rand(5, 20) }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Franchise List -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 sm:mb-6 gap-4">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">All Franchises</h2>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <input wire:model.live="search" type="text" placeholder="Search..."
                            class="px-3 sm:px-4 py-2 border rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        <select wire:model.live="statusFilter"
                            class="px-3 sm:px-4 py-2 border rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                     
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <!-- Mobile Card Layout -->
                    <div class="block sm:hidden space-y-4">
                        @forelse($franchises as $franchise)
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center mb-2">
                                    <img class="h-8 w-8 rounded-full mr-3"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($franchise->franchise_name) }}&background=random"
                                        alt="">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $franchise->franchise_name }}
                                        </p>
                                        <p class="text-xs text-gray-500">ID:
                                            {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}{{ $franchise->id }}
                                        </p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-900">{{ $franchise->city }}, {{ $franchise->state }}</p>
                                <p class="text-xs text-gray-500">Est. {{ $franchise->created_at->format('Y') }}</p>
                                <p class="text-xs mt-2">
                                    <span
                                        class="px-2 py-1 font-semibold rounded-full 
                                    {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $franchise->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ ucfirst($franchise->status) }}
                                    </span>
                                </p>
                                <p class="text-xs text-gray-900 mt-2">₹{{ number_format(rand(1000, 50000), 2) }} <span
                                        class="text-gray-500">This month</span></p>
                                <p class="text-xs text-{{ rand(0, 1) ? 'green' : 'red' }}-600 font-medium mt-2">
                                    {{ rand(0, 1) ? '+' : '' }}{{ rand(1, 20) }}%</p>
                                <div class="flex gap-3 mt-3">
                                    <a href="{{ route('admin.view-franchises', $franchise->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-xs">View</a>
                                    <a href="{{ route('admin.edit-franchise', $franchise->id) }}"
                                        class="text-gray-600 hover:text-gray-900 text-xs">Edit</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center">No franchises found</p>
                        @endforelse
                    </div>
                    <!-- Desktop Table Layout -->
                    <table class="min-w-full divide-y divide-gray-200 hidden sm:table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="sortBy('franchise_name')">
                                    Franchise
                                    @if ($sortField === 'franchise_name')
                                        <i
                                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                        <i class="fas fa-sort ml-1"></i>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="sortBy('status')">
                                    Status
                                    @if ($sortField === 'status')
                                        <i
                                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                        <i class="fas fa-sort ml-1"></i>
                                    @endif
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Revenue
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Growth
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($franchises as $franchise)
                                <tr>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 sm:h-10 w-8 sm:w-10">
                                                <img class="h-8 sm:h-10 w-8 sm:w-10 rounded-full"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($franchise->franchise_name) }}&background=random"
                                                    alt="">
                                            </div>
                                            <div class="ml-3 sm:ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $franchise->franchise_name }}</div>
                                                <div class="text-xs sm:text-sm text-gray-500">ID:
                                                    {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}{{ $franchise->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs sm:text-sm text-gray-900">{{ $franchise->city }},
                                            {{ $franchise->state }}</div>
                                        <div class="text-xs text-gray-500">Est.
                                            {{ $franchise->created_at->format('Y') }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $franchise->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ ucfirst($franchise->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs sm:text-sm text-gray-900">
                                            ₹{{ number_format(rand(1000, 50000), 2) }}</div>
                                        <div class="text-xs text-gray-500">This month</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="text-{{ rand(0, 1) ? 'green' : 'red' }}-600 text-xs sm:text-sm font-medium">
                                            {{ rand(0, 1) ? '+' : '' }}{{ rand(1, 20) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                        <a href="{{ route('admin.view-franchises', $franchise->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-2 sm:mr-3">View</a>
                                        <a href="{{ route('admin.edit-franchise', $franchise->id) }}"
                                            class="text-gray-600 hover:text-gray-900">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">
                                        No franchises found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $franchises->links() }}
                </div>
            </div>
        </main>

      @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            // Store chart instances globally
            window.dashboardCharts = {
                revenue: null,
                performance: null
            };

            // Initialize charts on first load and subsequent updates
            Livewire.hook('morph.added', (el, component) => {
                if (component.name === 'admin.admin-dashboard') {
                    initCharts(component.serverMemo.data);
                }
            });

            Livewire.hook('morph.updated', (el, component) => {
                if (component.name === 'admin.admin-dashboard') {
                    updateCharts(component.serverMemo.data);
                }
            });

            // Handle window resize with debounce
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    if (window.dashboardCharts.revenue) window.dashboardCharts.revenue.resize();
                    if (window.dashboardCharts.performance) window.dashboardCharts.performance.resize();
                }, 200);
            });

            function initCharts(data) {
                destroyCharts();
                createCharts(data);
            }

            function updateCharts(data) {
                if (!window.dashboardCharts.revenue || !window.dashboardCharts.performance) {
                    initCharts(data);
                } else {
                    updateChartData(data);
                }
            }

            function destroyCharts() {
                if (window.dashboardCharts.revenue) {
                    window.dashboardCharts.revenue.destroy();
                    window.dashboardCharts.revenue = null;
                }
                if (window.dashboardCharts.performance) {
                    window.dashboardCharts.performance.destroy();
                    window.dashboardCharts.performance = null;
                }
            }

            function createCharts(data) {
                // Revenue Chart
                const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
                if (revenueCtx) {
                    window.dashboardCharts.revenue = new Chart(revenueCtx, {
                        type: 'line',
                        data: formatRevenueData(data.revenueChartData),
                        options: getChartOptions('line')
                    });
                }

                // Performance Chart
                const performanceCtx = document.getElementById('performanceChart')?.getContext('2d');
                if (performanceCtx) {
                    window.dashboardCharts.performance = new Chart(performanceCtx, {
                        type: 'bar',
                        data: formatPerformanceData(data.performanceChartData),
                        options: getChartOptions('bar')
                    });
                }
            }

            function updateChartData(data) {
                if (window.dashboardCharts.revenue) {
                    window.dashboardCharts.revenue.data = formatRevenueData(data.revenueChartData);
                    window.dashboardCharts.revenue.update();
                }

                if (window.dashboardCharts.performance) {
                    window.dashboardCharts.performance.data = formatPerformanceData(data.performanceChartData);
                    window.dashboardCharts.performance.update();
                }
            }

            function formatRevenueData(chartData) {
                const labels = chartData?.labels?.length ? chartData.labels : generateDefaultMonths();
                const data = chartData?.data?.length ? chartData.data : Array(labels.length).fill(0);

                return {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: data,
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderColor: 'rgba(67, 97, 238, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                };
            }

            function formatPerformanceData(chartData) {
                const labels = chartData?.labels?.length ? 
                    chartData.labels : 
                    ['Franchise 1', 'Franchise 2', 'Franchise 3', 'Franchise 4', 'Franchise 5'];
                
                const data = chartData?.data?.length ? 
                    chartData.data : 
                    Array(labels.length).fill(0);

                return {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: data,
                        backgroundColor: [
                            'rgba(67, 97, 238, 0.7)',
                            'rgba(103, 114, 229, 0.7)',
                            'rgba(72, 149, 239, 0.7)',
                            'rgba(239, 68, 68, 0.7)',
                            'rgba(16, 185, 129, 0.7)'
                        ],
                        borderColor: [
                            'rgba(67, 97, 238, 1)',
                            'rgba(103, 114, 229, 1)',
                            'rgba(72, 149, 239, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(16, 185, 129, 1)'
                        ],
                        borderWidth: 1
                    }]
                };
            }

            function generateDefaultMonths() {
                const months = [];
                const date = new Date();
                for (let i = 0; i < 6; i++) {
                    date.setMonth(date.getMonth() - 1);
                    months.unshift(date.toLocaleString('default', { month: 'short', year: 'numeric' }));
                }
                return months;
            }

            function getChartOptions(type) {
                const baseOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `₹${context.parsed.y?.toLocaleString() || '0'}`;
                                },
                                title: function(context) {
                                    return context[0].label || 'Unknown period';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                },
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        }
                    }
                };

                if (type === 'line') {
                    baseOptions.interaction = {
                        intersect: false,
                        mode: 'index'
                    };
                }

                return baseOptions;
            }
        });
    </script>
@endpush
    </div>

    <style>
        /* Custom styles for table responsiveness */
        @media (max-width: 640px) {
            .chart-container {
                max-height: 250px;
            }

            canvas {
                width: 100% !important;
            }
        }
    </style>
</div>
