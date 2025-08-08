<div class="container mx-auto px-4 py-8" x-data="{ activeTab: 'details' }">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Staff Header -->
        <div class="bg-gray-50 px-6 py-4 border-b">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ $staff->image ? asset('storage/'.$staff->image) : asset('images/default-staff.png') }}" 
                             alt="{{ $staff->name }}" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $staff->name }}</h1>
                        <p class="text-gray-600">{{ $staff->serviceCategory->name ?? 'No Category' }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($staff->status) }}
                    </span>
                    <button wire:click="$dispatch('edit-staff', { id: {{ $staff->id }} })" 
                            class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                        Edit
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex overflow-x-auto">
                <button @click="activeTab = 'details'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'details', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'details' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Details
                </button>
                <button @click="activeTab = 'documents'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'documents', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'documents' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Documents
                </button>
                <button @click="activeTab = 'performance'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'performance', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'performance' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Performance
                </button>
                <button @click="activeTab = 'services'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'services', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'services' }"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Recent Services
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Details Tab -->
            <div x-show="activeTab === 'details'" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="text-gray-900">{{ $staff->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-900">{{ $staff->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Contact Number</p>
                                <p class="text-gray-900">{{ $staff->contact }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="text-gray-900">{{ $staff->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Employment Information</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Service Category</p>
                                <p class="text-gray-900">{{ $staff->serviceCategory->name ?? 'Not assigned' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Salary</p>
                                <p class="text-gray-900">₹{{ number_format($staff->salary, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Joined On</p>
                                <p class="text-gray-900">{{ $staff->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Franchise</p>
                                <p class="text-gray-900">{{ $staff->franchise->name ?? 'Not assigned' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Tab -->
            <div x-show="activeTab === 'documents'" x-cloak x-transition>
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Documents</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-900">Aadhar Card</h4>
                            <div class="mt-3">
                                @if($staff->aadhar_document)
                                    <a href="{{ asset('storage/'.$staff->aadhar_document) }}" target="_blank" 
                                       class="text-blue-600 text-sm font-medium hover:underline">
                                        View Document
                                    </a>
                                @else
                                    <p class="text-sm text-gray-500">Document not uploaded</p>
                                @endif
                            </div>
                        </div>
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-900">PAN Card</h4>
                            <div class="mt-3">
                                @if($staff->pan_document)
                                    <a href="{{ asset('storage/'.$staff->pan_document) }}" target="_blank" 
                                       class="text-blue-600 text-sm font-medium hover:underline">
                                        View Document
                                    </a>
                                @else
                                    <p class="text-sm text-gray-500">Document not uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          <div x-show="activeTab === 'performance'" x-cloak x-transition
     x-data="{
        chart: null,
        chartType: '{{ $chartType }}',
        performanceRange: '{{ $performanceRange }}',
        initChart() {
            const ctx = this.$refs.chartCanvas.getContext('2d');
            this.chart = new Chart(ctx, {
                type: this.chartType,
                data: {
                    labels: @json($performanceData['labels']),
                    datasets: [
                        {
                            label: 'Services Completed',
                            data: @json($performanceData['services']),
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Revenue (₹)',
                            data: @json($performanceData['revenues']),
                            backgroundColor: 'rgba(16, 185, 129, 0.5)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            type: 'line',
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
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Services Completed'
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
     x-init="initChart"
     @refresh-chart.window="refreshChart()"
     @update-chart.window="updateChart($event.detail.type)">
    <div class="space-y-4">
        <h3 class="text-lg font-medium text-gray-900">Performance Metrics</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-500">Total Services</h4>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $performanceData['total_services'] }}</p>
            </div>
            <div class="border rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-500">Total Revenue</h4>
                <p class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($performanceData['total_revenue'], 2) }}</p>
            </div>
            <div class="border rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-500">Performance Trend</h4>
                <p class="text-2xl font-bold text-gray-900 mt-1 flex items-center">
                    {{ $performanceData['performance_change'] }}%
                    <span x-html="$performanceData['performance_change'] >= 0 ? '&uarr;' : '&darr;'" 
                          :class="$performanceData['performance_change'] >= 0 ? 'text-green-500' : 'text-red-500'" 
                          class="ml-1"></span>
                </p>
            </div>
        </div>

        <!-- Performance Chart -->
        <div class="mt-6 border rounded-lg p-4 bg-gray-50">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                <h4 class="font-medium text-gray-900">Performance Overview</h4>
                <div class="flex gap-2">
                    <select x-model="chartType" @change="$wire.chartType = chartType" 
                            class="border rounded px-2 py-1 text-sm">
                        <option value="bar">Bar Chart</option>
                        <option value="line">Line Chart</option>
                    </select>
                    <select x-model="performanceRange" @change="$wire.performanceRange = performanceRange" 
                            class="border rounded px-2 py-1 text-sm">
                        <option value="1month">Last 1 Month</option>
                        <option value="3months">Last 3 Months</option>
                        <option value="6months">Last 6 Months</option>
                        <option value="1year">Last 1 Year</option>
                    </select>
                </div>
            </div>
            <div class="h-64">
                <canvas id="performanceChart" x-ref="chartCanvas"></canvas>
            </div>
        </div>
    </div>
</div>

            <!-- Services Tab -->
            <div x-show="activeTab === 'services'" x-cloak x-transition>
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Services</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Problem</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($staff->serviceRequests()->latest()->take(10)->get() as $service)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->service_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->product_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($service->problem, 30) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹{{ number_format($service->service_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $service->status == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $service->status == 1 ? 'Completed' : 'In Progress' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No services found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush