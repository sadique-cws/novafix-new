 <main class="p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="card stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-store text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Total Franchises</p>
                                <h3 class="text-2xl font-bold">128</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-green-500 font-medium">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                            </p>
                        </div>
                    </div>

                    <div class="card stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Total Customers</p>
                                <h3 class="text-2xl font-bold">3,421</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-green-500 font-medium">
                                <i class="fas fa-arrow-up mr-1"></i> 5% from last month
                            </p>
                        </div>
                    </div>

                    <div class="card stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <i class="fas fa-wrench text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Services Completed</p>
                                <h3 class="text-2xl font-bold">1,847</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-red-500 font-medium">
                                <i class="fas fa-arrow-down mr-1"></i> 8% from last month
                            </p>
                        </div>
                    </div>

                    <div class="card stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                                <i class="fas fa-file-invoice-dollar text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Total Revenue</p>
                                <h3 class="text-2xl font-bold">$124,832</h3>
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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="card bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Revenue Growth</h2>
                            <div class="flex">
                                <button class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded mr-2">Monthly</button>
                                <button class="px-3 py-1 text-sm text-gray-500 hover:bg-gray-100 rounded">Yearly</button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <div class="card bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Franchise Performance</h2>
                            <select class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Top Performing</option>
                                <option>Mid Performing</option>
                                <option>Low Performing</option>
                            </select>
                        </div>
                        <div class="chart-container">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity and Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="card bg-white rounded-lg shadow p-6 lg:col-span-2">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Recent Orders</h2>
                            <a href="#" class="text-sm text-blue-600 hover:underline">View All</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SC-2023-4872</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Smith</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oil Change</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$85.00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SC-2023-4871</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sarah Johnson</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Engine Diagnostic</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$120.00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SC-2023-4870</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Michael Brown</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tire Rotation</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$65.00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SC-2023-4869</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Emily Davis</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Brake Inspection</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Cancelled</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
                        <div class="space-y-4">
                            <button class="w-full flex items-center justify-between p-4 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                                <span>Add New Franchise</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="w-full flex items-center justify-between p-4 bg-green-50 text-green-600 rounded-lg hover:bg-green-100">
                                <span>Create Invoice</span>
                                <i class="fas fa-file-invoice"></i>
                            </button>
                            <button class="w-full flex items-center justify-between p-4 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100">
                                <span>Schedule Service</span>
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                            <button class="w-full flex items-center justify-between p-4 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-100">
                                <span>Generate Report</span>
                                <i class="fas fa-chart-pie"></i>
                            </button>
                        </div>

                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notifications</h2>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="p-2 bg-blue-100 text-blue-600 rounded-full mr-3">
                                        <i class="fas fa-info-circle text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">New franchise application submitted</p>
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
