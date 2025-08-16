<div class="container mx-auto py-2" x-data="{ activeTab: 'details' }">
    <!-- Staff Profile Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <!-- Staff Header with Gradient Background -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-5 sm:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div
                        class="h-16 w-16 sm:h-20 sm:w-20 rounded-full overflow-hidden bg-white border-2 border-white shadow">
                        <img src="{{ $staff->image ? asset('storage/' . $staff->image) : asset('images/default-staff.png') }}"
                            alt="{{ $staff->name }}" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $staff->name }}</h1>
                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            <span
                                class="px-2 py-1 rounded-full text-xs sm:text-sm font-medium bg-white bg-opacity-20 text-white">
                                {{ $staff->serviceCategory->name ?? 'No Category' }}
                            </span>
                            <span
                                class="px-2 py-1 rounded-full text-xs sm:text-sm font-medium 
                                {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($staff->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex hidden md:block flex-wrap gap-2 sm:gap-3 w-full sm:w-auto justify-end">
                    <button wire:click="$dispatch('edit-staff', { id: {{ $staff->id }} })"
                        class="flex items-center px-3 py-1.5 bg-white text-indigo-700 rounded-full text-sm font-medium hover:bg-opacity-90 transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Profile
                    </button>
                    <button
                        class="flex items-center px-3 py-1.5 bg-indigo-700 text-white rounded-full text-sm font-medium hover:bg-opacity-90 transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation - Scrollable on Mobile -->
        <div class="border-b border-gray-200 bg-white">
            <nav class="flex overflow-x-auto hide-scrollbar">
                <div class="flex">
                    <button @click="activeTab = 'details'"
                        :class="{ 'border-indigo-600 text-indigo-600': activeTab === 'details', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'details' }"
                        class="whitespace-nowrap py-4 px-4 sm:px-6 border-b-2 font-medium text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Details
                    </button>

                    <button @click="activeTab = 'performance'"
                        :class="{ 'border-indigo-600 text-indigo-600': activeTab === 'performance', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'performance' }"
                        class="whitespace-nowrap py-4 px-4 sm:px-6 border-b-2 font-medium text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                        Performance
                    </button>
                    <button @click="activeTab = 'services'"
                        :class="{ 'border-indigo-600 text-indigo-600': activeTab === 'services', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'services' }"
                        class="whitespace-nowrap py-4 px-4 sm:px-6 border-b-2 font-medium text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd" />
                        </svg>
                        Services
                    </button>
                </div>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-4 sm:p-6">
            <!-- Details Tab -->
            <div x-show="activeTab === 'details'" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information Card -->
                    <div class="bg-gray-50 rounded-lg p-5 sm:p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Personal Information
                            </h3>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $staff->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $staff->email }}</p>
                                </div>

                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Address</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $staff->address }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $staff->contact }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Aadhar</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $staff->aadhar ?: 'Not provided' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">PAN</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $staff->pan ?: 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information Card -->
                    <div class="bg-gray-50 rounded-lg p-5 sm:p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                                Employment Information
                            </h3>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Service
                                        Category</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $staff->serviceCategory->name ?? 'Not assigned' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        ₹{{ number_format($staff->salary, 2) }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Joined On</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $staff->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Franchise</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                        {{ $staff->franchise->name ?? 'Not assigned' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                                <div class="mt-1 flex items-center">
                                    <span
                                        class="flex h-2 w-2 rounded-full {{ $staff->status === 'active' ? 'bg-green-400' : 'bg-red-400' }} mr-2"></span>
                                    <span
                                        class="text-sm font-medium text-gray-900 capitalize">{{ $staff->status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Performance Tab -->
            <div x-show="activeTab === 'performance'" x-cloak x-transition x-data="{
                chart: null,
                chartType: '{{ $chartType }}',
                performanceRange: '{{ $performanceRange }}',
                initChart() {
                    const ctx = this.$refs.chartCanvas.getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: this.chartType,
                        data: {
                            labels: @json($performanceData['labels']),
                            datasets: [{
                                    label: 'Services Completed',
                                    data: @json($performanceData['services']),
                                    backgroundColor: 'rgba(99, 102, 241, 0.5)',
                                    borderColor: 'rgba(99, 102, 241, 1)',
                                    borderWidth: 2,
                                    tension: 0.1,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Revenue (₹)',
                                    data: @json($performanceData['revenues']),
                                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                    borderColor: 'rgba(16, 185, 129, 1)',
                                    borderWidth: 2,
                                    type: 'line',
                                    tension: 0.3,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.datasetIndex === 1) {
                                                label += '₹' + context.raw.toLocaleString();
                                            } else {
                                                label += context.raw;
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Services Completed'
                                    },
                                    grid: {
                                        drawOnChartArea: true,
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Revenue (₹)'
                                    },
                                    grid: {
                                        drawOnChartArea: false,
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return '₹' + value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                updateChart(type) {
                    this.chartType = type;
                    if (this.chart) {
                        this.chart.destroy();
                    }
                    this.initChart();
                },
                refreshChart() {
                    if (this.chart) {
                        this.chart.destroy();
                    }
                    this.initChart();
                }
            }"
                x-init="initChart" @refresh-chart.window="refreshChart()"
                @update-chart.window="updateChart($event.detail.type)">
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                        Performance Metrics
                    </h3>

                    <!-- Performance Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm">
                            <div class="flex items-center">
                                <div class="p-2 sm:p-3 rounded-lg bg-indigo-50 text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <p class="text-xs sm:text-sm font-medium text-gray-500">Total Services</p>
                                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">
                                        {{ $performanceData['total_services'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm">
                            <div class="flex items-center">
                                <div class="p-2 sm:p-3 rounded-lg bg-green-50 text-green-600">
                                    ₹
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <p class="text-xs sm:text-sm font-medium text-gray-500">Total Revenue</p>
                                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">
                                        ₹{{ number_format($performanceData['total_revenue'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm">
                            <div class="flex items-center">
                                <div
                                    class="p-2 sm:p-3 rounded-lg {{ $performanceData['performance_change'] >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <p class="text-xs sm:text-sm font-medium text-gray-500">Performance Trend</p>
                                    <p class="text-xl sm:text-2xl font-semibold text-gray-900 flex items-center">
                                        {{ $performanceData['performance_change'] }}%
                                        <span
                                            x-html="$performanceData['performance_change'] >= 0 ? '&uarr;' : '&darr;'"
                                            :class="$performanceData['performance_change'] >= 0 ? 'text-green-500' :
                                                'text-red-500'"
                                            class="ml-1 text-xs sm:text-sm"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Chart -->
                    <div class="mt-6 bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                            <h4 class="font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                </svg>
                                Performance Overview
                            </h4>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <select x-model="chartType" @change="$wire.chartType = chartType"
                                    class="border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="bar">Bar Chart</option>
                                    <option value="line">Line Chart</option>
                                </select>
                                <select x-model="performanceRange" @change="$wire.performanceRange = performanceRange"
                                    class="border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1month">Last 1 Month</option>
                                    <option value="3months">Last 3 Months</option>
                                    <option value="6months">Last 6 Months</option>
                                    <option value="1year">Last 1 Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="h-64 sm:h-80">
                            <canvas id="performanceChart" x-ref="chartCanvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Tab -->
            <div x-show="activeTab === 'services'" x-cloak x-transition>
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            Recent Services
                        </h3>
                        <div class="w-full sm:w-auto">
                            <select
                                class="border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full">
                                <option>Last 10 Services</option>
                                <option>Last Month</option>
                                <option>Last 3 Months</option>
                                <option>Last Year</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service Code</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Problem</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($staff->serviceRequests()->latest()->take(10)->get() as $service)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <a href="#"
                                                class="text-indigo-600 hover:text-indigo-900">{{ $service->service_code }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $service->product_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ $service->problem }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            ₹{{ number_format($service->service_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $service->status == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $service->status == 1 ? 'Completed' : 'In Progress' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $service->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No
                                            services found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-500">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span
                                class="font-medium">{{ $staff->serviceRequests()->count() }}</span> services
                        </p>
                        <nav class="flex items-center space-x-2">
                            <button
                                class="p-1 rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button
                                class="px-3 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</button>
                            <button
                                class="p-1 rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
