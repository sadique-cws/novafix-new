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
                    $total = $recentPayments->sum('total_amount');
                    if ($total >= 10000000) echo '₹' . round($total/10000000,1).'Cr';
                    elseif ($total >= 100000) echo '₹' . round($total/100000,1).'Lakh';
                    elseif ($total >= 1000) echo '₹' . round($total/1000,1).'k';
                    else echo '₹' . number_format($total,2);
                @endphp
            </h3>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid border grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Recent Services -->
        <div class="lg:col-span-2 bg-white rounded-md p-4">
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
                        @foreach ($recentServices as $service)
                            <tr class="border-b">
                                <td class="px-3 py-2">#{{ $service->service_code }}</td>
                                <td class="px-3 py-2">{{ $service->owner_name }}</td>
                                <td class="px-3 py-2">{{ $service->product_name }}</td>
                                <td class="px-3 py-2">
                                    @if ($service->status == 0)
                                        <span class="text-blue-600 text-xs">Diagnosis</span>
                                    @elseif($service->status < 0.5)
                                        <span class="text-yellow-600 text-xs">Repair</span>
                                    @elseif($service->status < 1)
                                        <span class="text-purple-600 text-xs">Quality Check</span>
                                    @else
                                        <span class="text-green-600 text-xs">Ready</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">{{ \Carbon\Carbon::parse($service->estimate_delivery)->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-white  rounded-md p-4">
            <h2 class="text-sm mb-3 text-[#111827]">Service Status Breakdown</h2>
            <div class="space-y-3">
                @foreach ($statusBreakdown as $status => $count)
                    @php
                        $percentage = ($count / max(1, array_sum($statusBreakdown))) * 100;
                        $color = match ($status) {
                            'Diagnosis' => 'bg-[#1E40AF]',
                            'Repair' => 'bg-yellow-500',
                            'Quality Check' => 'bg-purple-600',
                            default => 'bg-[#10B981]',
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
    <div class="grid grid-cols-1 border lg:grid-cols-3 gap-6">
        <!-- Payments -->
        <div class="bg-white rounded-md p-4">
            <h2 class="text-sm mb-3 text-[#111827]">Recent Payments</h2>
            <div class="space-y-3">
                @foreach ($recentPayments as $payment)
                    <div class="flex justify-between text-sm p-2 bg-gray-50 rounded">
                        <div>
                            <p>#{{ $payment->serviceRequest->service_code }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[#10B981]">₹{{ number_format($payment->total_amount, 2) }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($payment->payment_method) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Technicians -->
        <div class="bg-white rounded-md p-4">
            <h2 class="text-sm mb-3 text-[#111827]">Top Technicians</h2>
            <div class="space-y-3">
                @foreach ($topTechnicians as $tech)
                    <div class="flex items-center gap-3 text-sm">
                        <div class="h-8 w-8 rounded-full bg-[#3B82F6] text-white flex items-center justify-center">
                            {{ substr($tech->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p>{{ $tech->name }}</p>
                            <p class="text-xs text-gray-500">{{ $tech->serviceCategory->name }}</p>
                        </div>
                        <div class="text-right text-xs text-[#1E40AF]">
                            {{ $tech->completed_services }} jobs
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Device Breakdown (Alpine.js SVG Donut) -->
        <div class="bg-white rounded-md p-4" 
             x-data="{
                devices: {{ json_encode($deviceBreakdown) }},
                colors: ['#1E40AF','#10B981','#F59E0B','#3B82F6'],
                circumference: 2 * Math.PI * 40,
                offset(index) {
                    let total = Object.values(this.devices).reduce((a,b)=>a+b,0);
                    let sum = Object.values(this.devices).slice(0,index).reduce((a,b)=>a+b,0);
                    return this.circumference * (sum / total);
                },
                dash(index) {
                    let total = Object.values(this.devices).reduce((a,b)=>a+b,0);
                    let value = Object.values(this.devices)[index];
                    return this.circumference * (value / total);
                }
             }">
            <h2 class="text-sm mb-3 text-[#111827]">Device Breakdown</h2>
            <div class="flex flex-col items-center">
                <svg class="w-32 h-32 -rotate-90">
                    <template x-for="(count, i) in Object.values(devices)" :key="i">
                        <circle cx="50%" cy="50%" r="40" fill="transparent"
                            :stroke="colors[i]" stroke-width="10"
                            :stroke-dasharray="dash(i) + ',' + circumference"
                            :stroke-dashoffset="offset(i)" />
                    </template>
                </svg>
                <div class="mt-3 space-y-1 text-xs text-gray-600">
                    <template x-for="(count, name, i) in devices" :key="i">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full" :style="{ background: colors[i] }"></span>
                            <span x-text="name + ' ('+ count +')'"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
