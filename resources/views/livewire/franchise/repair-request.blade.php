<div class="space-y-6">
    <!-- Filters and Search -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <x-ui.input type="text" wire:model.live="search" placeholder="Search by name, email, phone or service code..." />
        </div>
        <div class="w-full md:w-64 shrink-0">
            <x-ui.select wire:model.live="statusFilter">
                <option value="">All Statuses</option>
                <option value="0">Pending</option>
                <option value="50">In Progress</option>
                <option value="100">Completed</option>
                <option value="90">Cancelled</option>
            </x-ui.select>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('service_code')">
                    Service Code
                    @if($sortField === 'service_code')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('owner_name')">
                    Customer
                    @if($sortField === 'owner_name')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">
                    Product
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer" wire:click="sortBy('status')">
                    Status
                    @if($sortField === 'status')
                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-blue-500"></i>
                    @else
                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                    @endif
                </th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
            </x-slot>

            @forelse ($requests as $request)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">{{ $request->service_code }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $request->owner_name }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $request->product_name }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">
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
                    <td class="px-5 py-4 text-sm text-right font-medium">
                        <div class="flex justify-end space-x-3">
                            <a wire:navigate href="{{ route('franchise.repair-request.view', $request->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="View">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">
                        <i class="fas fa-tools text-4xl mb-4 text-gray-300 block"></i>
                        No repair requests found.
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        @if($requests->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>