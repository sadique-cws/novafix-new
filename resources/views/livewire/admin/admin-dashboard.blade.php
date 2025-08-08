<div>
    <!-- Main content area -->
    <main class="flex-1 overflow-y-auto  sm:p-4 bg-gray-50">
        <!-- Dashboard Overview -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Dashboard Overview</h1>
            <p class="text-gray-600">Welcome back! Here's what's happening with your franchises today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Franchises -->
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Franchises</p>
                        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $franchiseCount }}</p>
                        <p class="text-sm text-green-600 mt-2"><span class="font-medium">+3.2%</span> from last month</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-store text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Staff -->
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Staff</p>
                        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $staffCount }}</p>
                        <p class="text-sm text-green-600 mt-2"><span class="font-medium">+5.7%</span> from last month
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <div class="flex flex-col xs:flex-row items-start xs:items-center justify-between gap-3 xs:gap-4">
                    <div class="flex-1 min-w-0"> <!-- Added min-w-0 to prevent text overflow -->
                        <p class="text-xs xs:text-sm font-medium text-gray-500">Recepoinst</p>
                        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $receptionistCount }}</p>
                        <p class="text-sm text-green-600 mt-2"><span class="font-medium">+20%</span> from last month
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-2.5 xs:p-3 rounded-full self-end xs:self-auto ml-auto xs:ml-0">
                        <i class="fas fa-tasks text-yellow-600 text-base xs:text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue -->
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                        <p class="text-3xl font-semibold text-gray-800 mt-1">₹{{ number_format($totalPayments, 2) }}</p>
                        <p class="text-sm text-green-600 mt-2"><span class="font-medium">+12.4%</span> from last month
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Revenue Overview</h2>
                    <select
                        class="text-sm border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option selected>Last 12 Months</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Franchise Performance -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Top Performing Franchises</h2>
                    <select
                        class="text-sm border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>By Revenue</option>
                        <option selected>By Growth</option>
                        <option>By Customer Satisfaction</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Top Franchises -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                            <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">New staff member added</p>
                            <p class="text-xs text-gray-500">John Doe joined New York franchise</p>
                            <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i class="fas fa-money-bill-wave text-green-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Payment received</p>
                            <p class="text-xs text-gray-500">$2,450 from Chicago franchise</p>
                            <p class="text-xs text-gray-400 mt-1">5 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                            <i class="fas fa-store text-purple-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">New franchise application</p>
                            <p class="text-xs text-gray-500">Application from Miami, FL received</p>
                            <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Maintenance alert</p>
                            <p class="text-xs text-gray-500">Equipment issue reported at Houston franchise</p>
                            <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Franchises -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Top Franchises This Month</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-medium">1</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">New York Downtown</p>
                            <p class="text-xs text-gray-500">$42,800 revenue</p>
                        </div>
                        <span class="text-green-600 text-sm font-medium">+12%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-medium">2</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Chicago North</p>
                            <p class="text-xs text-gray-500">$38,500 revenue</p>
                        </div>
                        <span class="text-green-600 text-sm font-medium">+8%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-medium">3</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Los Angeles West</p>
                            <p class="text-xs text-gray-500">$35,200 revenue</p>
                        </div>
                        <span class="text-green-600 text-sm font-medium">+15%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                            <span class="text-gray-600 font-medium">4</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Houston Central</p>
                            <p class="text-xs text-gray-500">$28,750 revenue</p>
                        </div>
                        <span class="text-red-600 text-sm font-medium">-2%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Franchise List -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">All Franchises</h2>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i> Add New
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Franchise</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Location</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Revenue</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Growth</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://placehold.co/40x40"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">New York Downtown</div>
                                        <div class="text-sm text-gray-500">ID: NY001</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">New York, NY</div>
                                <div class="text-sm text-gray-500">Est. 2018</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge status-active">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">$42,800</div>
                                <div class="text-sm text-gray-500">This month</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-green-600 text-sm font-medium">+12%</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://placehold.co/40x40"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Chicago North</div>
                                        <div class="text-sm text-gray-500">ID: CH002</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Chicago, IL</div>
                                <div class="text-sm text-gray-500">Est. 2019</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge status-active">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">$38,500</div>
                                <div class="text-sm text-gray-500">This month</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-green-600 text-sm font-medium">+8%</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://placehold.co/40x40"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Los Angeles West</div>
                                        <div class="text-sm text-gray-500">ID: LA003</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Los Angeles, CA</div>
                                <div class="text-sm text-gray-500">Est. 2020</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge status-active">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">$35,200</div>
                                <div class="text-sm text-gray-500">This month</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-green-600 text-sm font-medium">+15%</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://placehold.co/40x40"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Houston Central</div>
                                        <div class="text-sm text-gray-500">ID: HO004</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Houston, TX</div>
                                <div class="text-sm text-gray-500">Est. 2021</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge status-pending">Pending</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">$28,750</div>
                                <div class="text-sm text-gray-500">This month</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-red-600 text-sm font-medium">-2%</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Revenue ($)',
                        data: [18500, 22000, 24500, 28000, 32000, 35000, 38000, 42000, 39000, 43000,
                            47000, 52000
                        ],
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderColor: 'rgba(67, 97, 238, 1)',
                        borderWidth: 2,
                        tension: 0.4,
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
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
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

            // Performance Chart
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            new Chart(performanceCtx, {
                type: 'bar',
                data: {
                    labels: ['New York', 'Chicago', 'Los Angeles', 'Houston', 'Miami'],
                    datasets: [{
                        label: 'Growth %',
                        data: [12, 8, 15, -2, 5],
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
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
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
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.add('active');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>

</div>