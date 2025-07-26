<main class="flex-1 p-4 md:p-6 overflow-auto bg-gray-50">


    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Today's Services -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Today's Services</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($todayServicesCount) }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-green-600 text-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                {{ round(($todayServicesCount/max(1, $todayServicesCount-5))*100) }}% from yesterday
            </p>
        </div>

        <!-- In Progress -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">In Progress</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($inProgressCount) }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-blue-600 text-sm">
                {{ round(($inProgressCount/max(1, $todayServicesCount)*100) )}}% of today's work
            </p>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Completed</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($completedCount) }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-green-600 text-sm">
                {{ round(($completedCount/max(1, $todayServicesCount)*100) )}}% completion rate
            </p>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Today's Revenue</p>
                    <h3 class="text-3xl font-bold text-gray-800">₹{{ number_format($recentPayments->sum('total_amount'), 2) }}</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-green-600 text-sm">
                {{ $recentPayments->count() }} payments today
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <a wire:navigate href="{{route('frontdesk.servicerequest.create')}}" class="bg-white rounded-xl shadow-md p-4 flex items-center justify-between hover:bg-blue-50 hover:border-blue-200 border border-transparent transition group">
            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">New Service</span>
            <div class="bg-blue-100 p-2 rounded-full group-hover:bg-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
        </a>

        <a wire:navigate href="{{route('frontdesk.servicerequest.manage')}}" class="bg-white rounded-xl shadow-md p-4 flex items-center justify-between hover:bg-green-50 hover:border-green-200 border border-transparent transition group">
            <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">Manage Services</span>
            <div class="bg-green-100 p-2 rounded-full group-hover:bg-green-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
            </div>
        </a>

        <a wire:navigate href="{{route('frontdesk.servicerequest.completed')}}" class="bg-white rounded-xl shadow-md p-4 flex items-center justify-between hover:bg-purple-50 hover:border-purple-200 border border-transparent transition group">
            <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Complete Task</span>
            <div class="bg-purple-100 p-2 rounded-full group-hover:bg-purple-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </a>

        <a wire:navigate href="{{route('frontdesk.manage.payments')}}" class="bg-white rounded-xl shadow-md p-4 flex items-center justify-between hover:bg-orange-50 hover:border-orange-200 border border-transparent transition group">
            <span class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Payment Lookup</span>
            <div class="bg-orange-100 p-2 rounded-full group-hover:bg-orange-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Recent Service Requests -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Recent Service Requests</h2>
                <a href="{{ route('frontdesk.servicerequest.manage') }}" class="text-sm font-medium text-blue-600 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket #</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Est. Delivery</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentServices as $service)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $service->service_code }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $service->owner_name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $service->product_name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($service->status == 0)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diagnosis</span>
                                @elseif($service->status < 0.5)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Repair</span>
                                @elseif($service->status < 1)
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Quality Check</span>
                                @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Ready for Pickup</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $service->estimate_delivery  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Service Status Breakdown</h2>
            <div class="space-y-4">
                @foreach($statusBreakdown as $status => $count)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">{{ $status }}</span>
                        <span class="text-sm text-gray-600">{{ $count }}</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-200">
                        @php
                            $percentage = ($count / max(1, array_sum($statusBreakdown))) * 100;
                            $color = match($status) {
                                'Diagnosis' => 'bg-blue-600',
                                'Repair' => 'bg-yellow-500',
                                'Quality Check' => 'bg-purple-600',
                                default => 'bg-green-500'
                            };
                        @endphp
                        <div class="h-2 rounded-full {{ $color }}" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6 space-y-2">
                @foreach($statusBreakdown as $status => $count)
                <div class="flex items-center gap-2">
                    @php
                        $color = match($status) {
                            'Diagnosis' => 'bg-blue-600',
                            'Repair' => 'bg-yellow-500',
                            'Quality Check' => 'bg-purple-600',
                            default => 'bg-green-500'
                        };
                    @endphp
                    <span class="w-3 h-3 {{ $color }} rounded-full"></span>
                    <span class="text-sm text-gray-600">{{ $status }} ({{ round(($count / max(1, array_sum($statusBreakdown)) * 100)) }}%)</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Recent Payments -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Recent Payments</h2>
                <a href="" class="text-sm font-medium text-blue-600 hover:underline">View All</a>
            </div>
            <div class="space-y-4">
                @foreach($recentPayments as $payment)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#{{ $payment->serviceRequest->service_code }}</p>
                        <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, h:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-green-600">₹{{ number_format($payment->total_amount, 2) }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($payment->payment_method) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Technicians -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Top Technicians</h2>
            <div class="space-y-4">
                @foreach($topTechnicians as $tech)
                <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
                    <div class="flex-shrink-0">
                        @if($tech->image)
                        <img class="h-10 w-10 rounded-full" src="https://cdn-icons-png.flaticon.com/512/6342/6342703.png" alt="">
                        @else
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                            {{ substr($tech->name, 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $tech->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $tech->serviceCategory->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-blue-600">{{ $tech->completed_services }} jobs</p>
                        <p class="text-xs text-gray-500">{{ round(($tech->completed_services/max(1, $completedCount))*100) }}% share</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Device Breakdown -->
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Device Type Breakdown</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <canvas id="deviceChart" class="w-full" height="200"></canvas>
                </div>
                <div class="flex flex-col justify-center space-y-3">
                    @php
                        $colors = ['bg-blue-600', 'bg-green-500', 'bg-yellow-500', 'bg-purple-600'];
                        $totalDevices = array_sum($deviceBreakdown);
                    @endphp
                    @foreach($deviceBreakdown as $device => $count)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">{{ $device }}</span>
                            <span class="text-sm text-gray-600">{{ $count }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-200">
                            <div class="h-2 rounded-full {{ $colors[$loop->index] }}" style="width: {{ ($count/max(1, $totalDevices))*100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('deviceChart').getContext('2d');
        const deviceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($deviceBreakdown)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($deviceBreakdown)) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(234, 179, 8, 0.8)',
                        'rgba(124, 58, 237, 0.8)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(124, 58, 237, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>
@endpush