<div class="space-y-6">
    <!-- Search and Actions -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <x-ui.input type="text" wire:model.live="search" placeholder="Search by name, contact, or email..." />
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Customer Name</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Contact</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase hidden sm:table-cell">Email</th>
                <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase">Total Requests</th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
            </x-slot>

            @forelse ($customers as $index => $customer)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">{{ $customer->name }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $customer->contact }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700 hidden sm:table-cell">{{ $customer->email ?? 'N/A' }}</td>
                    <td class="px-5 py-4 text-sm text-center">
                        <x-ui.badge color="blue">{{ $customer->service_requests_count }}</x-ui.badge>
                    </td>
                    <td class="px-5 py-4 text-sm text-right font-medium">
                        <div class="flex justify-end space-x-3">
                            <a wire:navigate href="{{ route('franchise.view.customer', $customer->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="View">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">
                        <i class="fas fa-users text-4xl mb-4 text-gray-300 block"></i>
                        No customers found.
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        @if($customers->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
