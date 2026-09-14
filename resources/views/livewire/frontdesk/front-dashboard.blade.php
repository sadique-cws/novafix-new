<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Services -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Today's Services</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($todayServicesCount) }}</h3>
        </div>

        <!-- In Progress -->
        <a wire:navigate href="{{ route('frontdesk.servicerequest.manage') }}" class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center hover:border-gray-300 transition-colors cursor-pointer group">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600 group-hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-tools"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">In Progress</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($inProgressCount) }}</h3>
        </a>

        <!-- Completed -->
        <a wire:navigate href="{{route('frontdesk.servicerequest.completed') }}" class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center hover:border-gray-300 transition-colors cursor-pointer group">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-100 transition-colors">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Completed</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($completedCount) }}</h3>
        </a>

        <!-- Revenue -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">24h Revenue</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">
                @php
                    $total = $todayRevenue;
                    if ($total >= 10000000) echo '₹' . round($total/10000000,1).'Cr';
                    elseif ($total >= 100000) echo '₹' . round($total/100000,1).'L';
                    elseif ($total >= 1000) echo '₹' . round($total/1000,1).'k';
                    else echo '₹' . number_format($total,2);
                @endphp
            </h3>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Services -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Recent Service Requests</h2>
                <a wire:navigate href="{{ route('frontdesk.servicerequest.manage') }}" class="text-sm font-medium text-primary hover:text-primary/80">View All</a>
            </div>
            <div class="overflow-x-auto">
                <x-ui.table>
                    <x-slot name="head">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Ticket #</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Customer</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Device</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Est. Delivery</th>
                    </x-slot>
                    
                    @forelse ($recentServices as $service)
                        <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                            <td class="px-5 py-3 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $service->service_code }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-700">{{ $service->owner_name }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-700">{{ $service->product_name }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">
                                @if ($service->status == 0)
                                    <x-ui.badge color="blue">Pending</x-ui.badge>
                                @elseif($service->status == 1)
                                    <x-ui.badge color="yellow">Processing</x-ui.badge>
                                @elseif($service->status == 2)
                                    <x-ui.badge color="green">Complete</x-ui.badge>
                                @elseif($service->status == 3)
                                    <x-ui.badge color="red">Reject</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-700">
                                @if($service->estimate_delivery)
                                    {{ \Carbon\Carbon::parse($service->estimate_delivery)->timezone('Asia/Kolkata')->format('M d, Y ')  }}
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">No recent service requests found.</td>
                        </tr>
                    @endforelse
                </x-ui.table>
            </div>
        </div>

        <!-- Device Breakdown -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Device Breakdown</h2>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    @forelse ($deviceBreakdown as $device => $count)
                        @php
                            $total = array_sum($deviceBreakdown);
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            $colors = ['Laptops' => 'bg-blue-600', 'Smartphones' => 'bg-green-600', 'Tablets' => 'bg-yellow-600', 'Others' => 'bg-purple-600'];
                            $color = $colors[$device] ?? 'bg-gray-600';
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm font-medium text-gray-700 mb-1.5">
                                <span>{{ $device }}</span>
                                <span>{{ $count }} ({{ round($percentage) }}%)</span>
                            </div>
                            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full {{ $color }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                         <p class="text-sm text-gray-500 text-center py-4">No data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payments -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Recent Payments</h2>
            </div>
            <div class="p-0">
                @forelse ($recentPayments as $payment)
                    <div class="flex justify-between items-center p-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div>
                            <p class="text-sm font-medium text-gray-900">#{{ $payment->serviceRequest->service_code ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $payment->created_at->timezone('Asia/Kolkata')->format('M d, h:i A') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-green-600">₹{{ number_format($payment->total_amount, 2) }}</p>
                            <p class="text-xs font-medium text-gray-500 mt-0.5">{{ ucfirst($payment->payment_method) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-500">No recent payments.</div>
                @endforelse
            </div>
        </div>

        <!-- Technicians -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Top Technicians</h2>
            </div>
            <div class="p-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-0">
                @forelse ($topTechnicians as $tech)
                    <div class="flex items-center justify-between p-4 border-b sm:border-r border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                {{ substr($tech->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $tech->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $tech->serviceCategory->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-ui.badge color="blue">{{ $tech->completed_services }} jobs</x-ui.badge>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-500 col-span-2">No technicians found.</div>
                @endforelse
                </div>
            </div>
        </div>
    </div>
</div>