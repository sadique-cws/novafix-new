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
                <p class="text-sm font-bold text-gray-500 uppercase mb-1">
                    {{ $shop->balance > 0 ? 'Outstanding Due' : 'Advance Balance' }}
                </p>
                <p class="text-2xl font-bold {{ $shop->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                    ₹{{ number_format(abs($shop->balance), 2) }}
                </p>
                <button type="button" x-data @click="$dispatch('open-modal', 'settleModal')" class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-5 rounded shadow-sm transition-colors">
                    Receive Payment
                </button>
            </div>
        </div>
    </div>

    <!-- Shop Ledger / Passbook -->
    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800"><i class="fas fa-book mr-2 text-gray-500"></i>Shop Passbook (Ledger)</h3>
        </div>
        <div class="overflow-x-auto">
            <x-ui.table>
                <x-slot name="head">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Description</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Ref (Service Code)</th>
                    <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                </x-slot>

                @forelse ($shop->ledgers as $ledger)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4 text-sm font-medium text-gray-600">
                            {{ $ledger->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                @if($ledger->type === 'debit')
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                @endif
                                <span class="text-sm font-bold text-gray-900">{{ $ledger->description ?? ($ledger->type === 'debit' ? 'Service Bill' : 'Payment Received') }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm font-medium text-gray-500">
                            {{ $ledger->serviceRequest ? $ledger->serviceRequest->service_code : '-' }}
                        </td>
                        <td class="px-5 py-4 text-right text-sm font-bold {{ $ledger->type === 'debit' ? 'text-red-600' : 'text-green-600' }}">
                            {{ $ledger->type === 'debit' ? '-' : '+' }}₹{{ number_format($ledger->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                            No transactions found in this shop's passbook.
                        </td>
                    </tr>
                @endforelse
            </x-ui.table>
        </div>
    </div>

    <!-- Settle Dues Modal -->
    <x-ui.modal name="settleModal" title="Receive Payment">
        <div class="p-2">
            <p class="text-sm text-gray-600 mb-4">
                Total Outstanding Balance: <span class="font-bold text-red-600">₹{{ number_format(abs($shop->balance), 2) }}</span>
            </p>
            
            <form wire:submit.prevent="settleDues">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Received</label>
                    <input type="number" step="0.01" wire:model="settle_amount"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" placeholder="Enter amount">
                    @error('settle_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" x-data @click="$dispatch('close-modal', 'settleModal')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>
</div>
