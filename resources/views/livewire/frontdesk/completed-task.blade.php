<div>
    <main class="flex-1 p-4 md:p-6 overflow-auto">
        <h2 class="text-2xl font-bold mb-6">Completed Service Requests</h2>

        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="w-full md:w-1/3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search completed requests..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Desktop/Tablet View -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('service_code')">
                                Service Code
                                @if ($sortField === 'service_code')
                                    {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('owner_name')">
                                Customer
                                @if ($sortField === 'owner_name')
                                    {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('product_name')">
                                Product
                                @if ($sortField === 'product_name')
                                    {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Completed Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Technician
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $request->service_code }}
                                </td>
                                <td class="px-6 py-4">
                                    <div>{{ $request->owner_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $request->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $request->contact }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>{{ $request->product_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $request->updated_at->format('M d, Y h:i A') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $request->technician->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('frontdesk.servicerequest.show', $request->id) }}"
                                            class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No completed service requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                @forelse($requests as $request)
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div class="font-medium text-gray-900">
                                {{ $request->service_code }}
                            </div>
                            <div class="text-sm text-green-800">
                                {{ $request->updated_at->format('M d, Y') }}
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <div class="font-medium">Customer:</div>
                            <div>{{ $request->owner_name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->contact }}</div>
                        </div>
                        
                        <div class="mt-2">
                            <div class="font-medium">Product:</div>
                            <div>{{ $request->product_name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}</div>
                        </div>
                        
                        <div class="mt-2">
                            <div class="font-medium">Technician:</div>
                            <div>{{ $request->technician->name ?? 'N/A' }}</div>
                        </div>
                        
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('frontdesk.servicerequest.show', $request->id) }}"
                                class="text-blue-600 hover:text-blue-900 px-3 py-1 rounded hover:bg-blue-50 text-sm font-medium"
                                title="View Details">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        No completed service requests found.
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $requests->links() }}
            </div>
        </div>

        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
                {{ session('message') }}
            </div>
        @endif
    </main>
</div>