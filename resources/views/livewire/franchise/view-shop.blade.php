<div class="space-y-6">
    <x-slot name="navbar_back">
        <a wire:navigate href="{{ route('franchise.manage.shops') }}" class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
    </x-slot>

    <!-- Shop Info Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Shop Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $shop->shop_name }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Owner Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $shop->owner_name }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Contact Number</p>
                <p class="text-lg font-semibold text-gray-900">{{ $shop->contact }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Total Bookings</p>
                <p class="text-lg font-semibold text-gray-900">
                    <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">
                        {{ $shop->serviceRequests->count() }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Email Address</p>
                <p class="text-md font-medium text-gray-800">{{ $shop->email ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">GST Number</p>
                <p class="text-md font-medium text-gray-800">{{ $shop->gst_number ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Address</p>
                <p class="text-md font-medium text-gray-800">{{ $shop->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Booking History Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Booking History (Service Requests)</h2>
        </div>
        <div class="overflow-x-auto">
            <x-ui.table>
                <x-slot name="head">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tracking ID</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Device</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Amount</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                </x-slot>

                @forelse ($shop->serviceRequests as $request)
                    <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                        <td class="px-5 py-4 font-medium text-blue-600 text-sm">
                            {{ $request->service_code }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-900 text-sm">{{ $request->product_name }}</div>
                            <div class="text-xs text-gray-500">{{ $request->brand }}</div>
                        </td>
                        <td class="px-5 py-4 text-sm font-medium">
                            ₹{{ number_format($request->service_amount, 2) }}
                        </td>
                        <td class="px-5 py-4 text-sm">
                            @if (in_array((string)$request->status, ['0', '1']))
                                <x-ui.badge color="yellow">Pending</x-ui.badge>
                            @elseif(in_array((string)$request->status, ['25', '50', '2']))
                                <x-ui.badge color="blue">In Progress</x-ui.badge>
                            @elseif(in_array((string)$request->status, ['100', '3']))
                                <x-ui.badge color="green">Completed</x-ui.badge>
                            @elseif((string)$request->status == '90')
                                <x-ui.badge color="red">Cancelled</x-ui.badge>
                            @else
                                <x-ui.badge color="gray">{{ $request->status ?? 'Unknown' }}</x-ui.badge>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-sm">
                            {{ $request->created_at->format('d M, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                            No service requests found for this shop.
                        </td>
                    </tr>
                @endforelse
            </x-ui.table>
        </div>
    </div>
</div>
