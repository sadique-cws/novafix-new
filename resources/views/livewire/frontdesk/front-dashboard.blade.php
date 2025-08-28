<main class="flex-1 p-4 md:p-6 overflow-auto bg-[#F9FAFB]">
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- Services -->
        <div class="bg-white border rounded-md p-4">
            <p class="text-xs text-gray-500">Today's Services</p>
            <h3 class="text-2xl text-[#111827]">{{ number_format($todayServicesCount) }}</h3>
        </div>

        <!-- In Progress -->
        <div class="bg-white border rounded-md p-4">
            <p class="text-xs text-gray-500">In Progress</p>
            <h3 class="text-2xl text-[#111827]">{{ number_format($inProgressCount) }}</h3>
        </div>

        <!-- Completed -->
        <div class="bg-white border rounded-md p-4">
            <p class="text-xs text-gray-500">Completed</p>
            <h3 class="text-2xl text-[#111827]">{{ number_format($completedCount) }}</h3>
        </div>

        <!-- Revenue -->
        <div class="bg-white border rounded-md p-4">
            <p class="text-xs text-gray-500">Today's Revenue</p>
            <h3 class="text-2xl text-[#111827]">
                @php
                    $total = $todayRevenue;
                    if ($total >= 10000000) echo '₹' . round($total/10000000,1).'Cr';
                    elseif ($total >= 100000) echo '₹' . round($total/100000,1).'Lakh';
                    elseif ($total >= 1000) echo '₹' . round($total/1000,1).'k';
                    else echo '₹' . number_format($total,2);
                @endphp
            </h3>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Recent Services -->
        <div class="lg:col-span-2 bg-white rounded-md p-4 border">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-sm text-[#111827]">Recent Service Requests</h2>
                <a href="{{ route('frontdesk.servicerequest.manage') }}" class="text-xs text-[#1E40AF]">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-3 py-2 text-left">Ticket #</th>
                            <th class="px-3 py-2 text-left">Customer</th>
                            <th class="px-3 py-2 text-left">Device</th>
                            <th class="px-3 py-2 text-left">Status</th>
                            <th class="px-3 py-2 text-left">Est. Delivery</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentServices as $service)
                            <tr class="border-b">
                                <td class="px-3 py-2">#{{ $service->service_code }}</td>
                                <td class="px-3 py-2">{{ $service->owner_name }}</td>
                                <td class="px-3 py-2">{{ $service->product_name }}</td>
                                <td class="px-3 py-2">
                                    @if ($service->status == 0)
                                        <span class="text-blue-600 text-xs">Diagnosis</span>
                                    @elseif($service->status == 25)
                                        <span class="text-yellow-600 text-xs">Processing</span>
                                    @elseif($service->status == 50)
                                        <span class="text-purple-600 text-xs">testing</span>
                                    @elseif($service->status == 100)
                                        <span class="text-green-600 text-xs">Complete</span>
                                     @elseif($service->status == 90)
                                        <span class="text-red-600 text-xs">Reject</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    @if($service->estimate_delivery)
                                        {{ \Carbon\Carbon::parse($service->estimate_delivery)->format('d-m-Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-2 text-center text-gray-500">No recent service requests</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-white rounded-md p-4 border">
            <h2 class="text-sm mb-3 text-[#111827]">Service Status Breakdown</h2>
            <div class="space-y-3">
                @foreach ($statusBreakdown as $status => $count)
                    @php
                        $total = array_sum($statusBreakdown);
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        $color = match ($status) {
                            'Diagnosis' => 'bg-blue-600',
                            'Repair' => 'bg-yellow-500',
                            'Quality Check' => 'bg-purple-600',
                            default => 'bg-green-500',
                        };
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>{{ $status }}</span>
                            <span>{{ $count }}</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full">
                            <div class="h-2 {{ $color }} rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payments -->
        <div class="bg-white rounded-md p-4 border">
            <h2 class="text-sm mb-3 text-[#111827]">Recent Payments</h2>
            <div class="space-y-3">
                @forelse ($recentPayments as $payment)
                    <div class="flex justify-between text-sm p-2 bg-gray-50 rounded">
                        <div>
                            <p>#{{ $payment->serviceRequest->service_code ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-green-600">₹{{ number_format($payment->total_amount, 2) }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($payment->payment_method) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent payments</p>
                @endforelse
            </div>
        </div>

        <!-- Technicians -->
        <div class="bg-white rounded-md p-4 border">
            <h2 class="text-sm mb-3 text-[#111827]">Top Technicians</h2>
            <div class="space-y-3">
                @forelse ($topTechnicians as $tech)
                    <div class="flex items-center gap-3 text-sm">
                        <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center">
                            {{ substr($tech->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p>{{ $tech->name }}</p>
                            <p class="text-xs text-gray-500">{{ $tech->serviceCategory->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right text-xs text-blue-600">
                            {{ $tech->completed_services }} jobs
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No technicians found</p>
                @endforelse
            </div>
        </div>

        <!-- Device Breakdown -->
        <div class="bg-white rounded-md p-4 border">
            <h2 class="text-sm mb-3 text-[#111827]">Device Breakdown</h2>
            <div class="flex flex-col items-center">
                <!-- Simple bar chart instead of SVG donut -->
                <div class="w-full space-y-2">
                    @foreach ($deviceBreakdown as $device => $count)
                        @php
                            $total = array_sum($deviceBreakdown);
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            $colors = ['Laptops' => 'bg-blue-600', 'Smartphones' => 'bg-green-600', 'Tablets' => 'bg-yellow-600', 'Others' => 'bg-purple-600'];
                            $color = $colors[$device] ?? 'bg-gray-600';
                        @endphp
                        <div>
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>{{ $device }}</span>
                                <span>{{ $count }} ({{ round($percentage) }}%)</span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full">
                                <div class="h-2 {{ $color }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>