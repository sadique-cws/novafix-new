<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <!-- Header with franchise selector -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2 md:mb-0">Franchise Performance</h2>
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative w-full sm:w-64">
                <select wire:model.live="selectedFranchise" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg">
                    <option value="all">All Franchises</option>
                    @foreach($franchises as $franchise)
                        <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative w-full sm:w-48">
                <select wire:model.live="timePeriod" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg">
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

    <!-- Key Performance Indicators -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Revenue Card -->
        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">₹{{ number_format($metrics['totalRevenue'], 2) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 12.4%
                        </span>
                        <span class="text-gray-500 text-sm ml-2">vs last period</span>
                    </div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-rupee-sign text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Customers</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $metrics['totalCustomers'] }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8.2%
                        </span>
                        <span class="text-gray-500 text-sm ml-2">vs last period</span>
                    </div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Services Card -->
        <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Services</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $metrics['completedServices'] }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 15.7%
                        </span>
                        <span class="text-gray-500 text-sm ml-2">vs last period</span>
                    </div>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-tools text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Satisfaction Card -->
        <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Satisfaction</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">94%</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 3.2%
                        </span>
                        <span class="text-gray-500 text-sm ml-2">vs last period</span>
                    </div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-smile text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Trend Chart -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-800">Revenue Trend</h3>
            </div>
            <div class="h-64">
                <canvas id="revenueTrendChart" wire:ignore wire:key="revenue-chart-{{ $chartUpdateKey }}"></canvas>
            </div>
        </div>

        <!-- Service Distribution Chart -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Service Distribution</h3>
            <div class="h-64">
                <canvas id="serviceDistributionChart" wire:ignore wire:key="service-chart-{{ $chartUpdateKey }}"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Customer Retention -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-3">Customer Retention</h3>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">New Customers</span>
                <span class="text-sm font-medium">{{ $metrics['customerRetention']['newCustomers'] }}</span>
            </div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">Returning Customers</span>
                <span class="text-sm font-medium">{{ $metrics['customerRetention']['returningCustomers'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Retention Rate</span>
                <span class="text-sm font-medium text-green-600">{{ $metrics['customerRetention']['retentionRate'] }}%</span>
            </div>
        </div>

        <!-- Staff Performance -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-3">Staff Performance</h3>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">Avg. Services/Staff</span>
                <span class="text-sm font-medium">{{ $metrics['staffPerformance']['avgServicesPerStaff'] }}</span>
            </div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">Top Performer</span>
                <span class="text-sm font-medium">{{ $metrics['staffPerformance']['topPerformer'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Satisfaction Score</span>
                <span class="text-sm font-medium text-green-600">4.8/5</span>
            </div>
        </div>

        <!-- Financial Health -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-3">Financial Health</h3>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">Profit Margin</span>
                <span class="text-sm font-medium text-green-600">{{ $metrics['financialHealth']['profitMargin'] }}%</span>
            </div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-600">Avg. Revenue/Day</span>
                <span class="text-sm font-medium">₹{{ number_format($metrics['financialHealth']['avgRevenuePerDay'], 2) }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Expense Ratio</span>
                <span class="text-sm font-medium text-yellow-600">{{ $metrics['financialHealth']['expenseRatio'] }}%</span>
            </div>
        </div>
    </div>

    <!-- Payment Details Section -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-800">Payment Transactions</h3>
            <div class="flex flex-col sm:flex-row gap-3 mt-2 md:mt-0">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="paymentSearch" placeholder="Search payments..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select wire:model.live="paymentStatus" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->transaction_id ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->serviceRequest->owner_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->serviceRequest->serviceCategory->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = [
                                    'completed' => 'status-completed',
                                    'pending' => 'status-pending',
                                    'failed' => 'status-inactive'
                                ][$payment->status] ?? 'status-inactive';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            <button class="text-gray-600 hover:text-gray-900">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="flex items-center justify-between mt-4">
            <div class="text-sm text-gray-500">
                Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} payments
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
            @foreach($activities as $activity)
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

@push('scripts')
<script>
// Store chart instances globally
let revenueChart, serviceChart;

function initCharts() {
    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueTrendChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueTrendData['labels']),
            datasets: [{
                label: 'Revenue (₹)',
                data: @json($revenueTrendData['data']),
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                borderColor: 'rgba(67, 97, 238, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₹' + context.raw.toLocaleString('en-IN');
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
                            return '₹' + value.toLocaleString('en-IN');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Service Distribution Chart
    const serviceCtx = document.getElementById('serviceDistributionChart').getContext('2d');
    serviceChart = new Chart(serviceCtx, {
        type: 'doughnut',
        data: {
            labels: @json($serviceDistributionData['labels']),
            datasets: [{
                data: @json($serviceDistributionData['data']),
                backgroundColor: [
                    'rgba(67, 97, 238, 0.8)',
                    'rgba(103, 114, 229, 0.8)',
                    'rgba(72, 149, 239, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(156, 163, 175, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });
}

function destroyCharts() {
    if (revenueChart) {
        revenueChart.destroy();
    }
    if (serviceChart) {
        serviceChart.destroy();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initCharts();
    
    // Listen for Livewire updates
    Livewire.hook('message.processed', (message, component) => {
        if (component.serverMemo.data.chartUpdateKey !== undefined) {
            destroyCharts();
            initCharts();
        }
    });
});
</script>
@endpush