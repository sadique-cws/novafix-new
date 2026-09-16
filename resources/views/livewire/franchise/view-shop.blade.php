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
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">Total Outstanding Dues</p>
                <p class="text-xl font-bold {{ $total_dues > 0 ? 'text-red-600' : 'text-green-600' }}">
                    ₹{{ number_format($total_dues, 2) }}
                </p>
                @if($total_dues > 0)
                <button type="button" x-data @click="$dispatch('open-modal', 'settleModal')" class="mt-2 bg-primary hover:bg-primary/90 text-white text-xs font-bold py-1.5 px-4 rounded transition-colors">
                    Settle Dues
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Shop Ledger / Request History -->
    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Recent Service Requests</h3>
        </div>
        <div class="overflow-x-auto">
            <x-ui.table>
                <x-slot name="head">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tracking ID</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Device</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Total Bill</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Due</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                </x-slot>

                @forelse ($shop->serviceRequests as $request)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-sm font-medium text-primary">
                            {{ $request->service_code }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $request->product_name }}</div>
                            <div class="text-xs text-gray-500">{{ $request->brand }}</div>
                        </td>
                        <td class="px-5 py-4 text-sm font-medium">
                            ₹{{ number_format($request->payment->total_amount ?? 0, 2) }}
                        </td>
                        <td class="px-5 py-4 text-sm font-bold {{ ($request->payment->due_amount ?? 0) > 0 ? 'text-red-600' : 'text-green-600' }}">
                            ₹{{ number_format($request->payment->due_amount ?? 0, 2) }}
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
                        <td colspan="6" class="px-5 py-8 text-center text-gray-500">
                            No service requests found for this shop.
                        </td>
                    </tr>
                @endforelse
            </x-ui.table>
        </div>
    </div>

    <!-- Settle Dues Modal -->
    <x-ui.modal name="settleModal" title="Settle Shop Dues">
        <div class="p-2">
            <p class="text-sm text-gray-600 mb-4">
                Total Outstanding: <span class="font-bold text-red-600">₹{{ number_format($total_dues, 2) }}</span>
            </p>
            
            <form wire:submit.prevent="settleDues">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Received</label>
                    <input type="number" step="0.01" wire:model="settle_amount" max="{{ $total_dues }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary p-2 border">
                    @error('settle_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" x-data @click="$dispatch('close-modal', 'settleModal')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-primary/90">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>
</div>
