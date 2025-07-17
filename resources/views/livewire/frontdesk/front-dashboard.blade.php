 <!-- Main Content - Adjusted for mobile sidebar -->
            <main class="flex-1 p-4 md:p-6 overflow-auto">
                <!-- Stats Cards - Responsive Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Cards remain the same as before -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Today's Services</p>
                                <h3 class="text-2xl font-bold">24</h3>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-tools text-primary text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-green-500 text-sm flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from yesterday
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">In Progress</p>
                                <h3 class="text-2xl font-bold">8</h3>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-spinner text-warning text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-green-500 text-sm flex items-center">
                                <i class="fas fa-arrow-down mr-1"></i> 3 less than yesterday
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Completed Today</p>
                                <h3 class="text-2xl font-bold">11</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-circle text-secondary text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-green-500 text-sm flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 20% from yesterday
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Items in Stock</p>
                                <h3 class="text-2xl font-bold">143</h3>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-boxes text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-red-500 text-sm flex items-center">
                                <i class="fas fa-arrow-down mr-1"></i> 7 need restocking
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions - Responsive Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                    <button class="bg-white rounded-lg shadow p-4 flex items-center justify-between hover:bg-primary hover:text-white transition-colors">
                        <span class="text-xs sm:text-sm">New Service</span>
                        <i class="fas fa-plus-circle text-xl"></i>
                    </button>
                    <button class="bg-white rounded-lg shadow p-4 flex items-center justify-between hover:bg-secondary hover:text-white transition-colors">
                        <span class="text-xs sm:text-sm">Quick Invoice</span>
                        <i class="fas fa-file-invoice text-xl"></i>
                    </button>
                    <button class="bg-white rounded-lg shadow p-4 flex items-center justify-between hover:bg-warning hover:text-white transition-colors">
                        <span class="text-xs sm:text-sm">Check Status</span>
                        <i class="fas fa-search text-xl"></i>
                    </button>
                    <button class="bg-white rounded-lg shadow p-4 flex items-center justify-between hover:bg-info hover:text-white transition-colors">
                        <span class="text-xs sm:text-sm">Customer Lookup</span>
                        <i class="fas fa-users text-xl"></i>
                    </button>
                </div>

                <!-- Main Content Grid - Responsive Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Service Requests -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Recent Service Requests</h2>
                            <button class="text-primary text-sm font-medium">View All</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-gray-500 text-sm">
                                        <th class="pb-2">Ticket #</th>
                                        <th class="pb-2">Customer</th>
                                        <th class="pb-2">Device</th>
                                        <th class="pb-2">Status</th>
                                        <th class="pb-2">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm space-y-2">
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3">#TC-8271</td>
                                        <td>John Smith</td>
                                        <td>MacBook Pro 15"</td>
                                        <td><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diagnosis</span></td>
                                        <td>Today</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3">#TC-8269</td>
                                        <td>Maria Garcia</td>
                                        <td>iPhone 13 Pro</td>
                                        <td><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Repair</span></td>
                                        <td>Today</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3">#TC-8265</td>
                                        <td>Robert Johnson</td>
                                        <td>Samsung QLED 55"</td>
                                        <td><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Ready</span></td>
                                        <td>Yesterday</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3">#TC-8261</td>
                                        <td>Sarah Williams</td>
                                        <td>Dell XPS 15</td>
                                        <td><span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Waiting</span></td>
                                        <td>Yesterday</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3">#TC-8258</td>
                                        <td>David Lee</td>
                                        <td>iPad Pro 12.9"</td>
                                        <td><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Ready</span></td>
                                        <td>2 days ago</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Status Breakdown -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold">Service Status</h2>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Diagnosis</span>
                                    <span class="text-sm font-medium text-gray-700">4</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 20%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Repair</span>
                                    <span class="text-sm font-medium text-gray-700">8</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 40%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Quality Check</span>
                                    <span class="text-sm font-medium text-gray-700">3</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: 15%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Ready for Pickup</span>
                                    <span class="text-sm font-medium text-gray-700">5</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-4 h-4 bg-blue-600 rounded-full"></div>
                                <span class="text-sm">Diagnosis (20%)</span>
                            </div>
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                                <span class="text-sm">Repair (40%)</span>
                            </div>
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-4 h-4 bg-purple-600 rounded-full"></div>
                                <span class="text-sm">Quality Check (15%)</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-green-600 rounded-full"></div>
                                <span class="text-sm">Ready (25%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Device Type Breakdown - Responsive Layout -->
                <div class="mt-6 bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Device Type Breakdown</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <img src="https://placehold.co/300x200" alt="Pie chart showing device types distribution" class="w-full h-auto rounded-lg mb-2">
                            <p class="text-center text-sm text-gray-600">Last 30 days service requests</p>
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="flex items-center mb-2">
                                <div class="w-4 h-4 bg-blue-600 rounded-full mr-2"></div>
                                <span class="text-sm">Laptops (45%)</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm">Smartphones (30%)</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-sm">Tablets (15%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-purple-600 rounded-full mr-2"></div>
                                <span class="text-sm">TVs (10%)</span>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="mb-2">
                                <h3 class="font-medium">Top Issues</h3>
                                <ul class="text-sm text-gray-600 list-disc pl-5">
                                    <li>Screen Replacement</li>
                                    <li>Battery Issues</li>
                                    <li>Water Damage</li>
                                    <li>Software Problems</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
