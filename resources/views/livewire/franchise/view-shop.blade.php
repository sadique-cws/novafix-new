<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-blue-800">Shop Details (B2B)</h1>
            <p class="text-gray-500 text-sm mt-1">View shop profile and booking history.</p>
        </div>
        <a wire:navigate href="{{ route('franchise.manage.shops') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Shops
        </a>
    </div>

    <!-- Shop Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Shop Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $shop->shop_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Owner Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $shop->owner_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Contact Number</p>
                <p class="text-lg font-semibold text-gray-900">{{ $shop->contact }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
                <p class="text-lg font-semibold text-gray-900">
                    <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">
                        {{ $shop->serviceRequests->count() }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-sm text-gray-500 mb-1">Email Address</p>
                <p class="text-md font-medium text-gray-800">{{ $shop->email ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">GST Number</p>
                <p class="text-md font-medium text-gray-800">{{ $shop->gst_number ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Address</p>
                <p class="text-md font-medium text-gray-800">{{ $shop->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Booking History Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Booking History (Service Requests)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-white border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-700">Tracking ID</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Device</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Amount</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($shop->serviceRequests as $request)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600">
                                {{ $request->service_code }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $request->product_name }}</div>
                                <div class="text-xs text-gray-500">{{ $request->brand }}</div>
                            </td>
                            <td class="px-6 py-4">
                                ₹{{ number_format($request->service_amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($request->status == 1)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Pending</span>
                                @elseif($request->status == 2)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">In Progress</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Completed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $request->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No service requests found for this shop.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
