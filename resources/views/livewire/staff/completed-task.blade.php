<div>
    <main class="flex-1 p-3 sm:p-4 md:p-6 overflow-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl  text-gray-800">Completed Service Requests</h2>
            <p class="text-sm sm:text-base text-gray-500 mt-1 sm:mt-0">{{ $requests->total() }} completed requests</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-4 sm:mb-6">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search completed requests..."
                    class="block w-full pl-10 pr-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- Service Code -->
                            <th scope="col" class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('service_code')">
                                <div class="flex items-center">
                                    <span class="hidden xs:inline">Service</span> Code
                                    @if ($sortField === 'service_code')
                                        <span class="ml-1">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </div>
                            </th>
                            
                            <!-- Customer -->
                            <th scope="col" class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('owner_name')">
                                <div class="flex items-center">
                                    Customer
                                    @if ($sortField === 'owner_name')
                                        <span class="ml-1">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </div>
                            </th>
                            
                            <!-- Product (hidden on smallest screens) -->
                            <th scope="col" class="hidden sm:table-cell px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_name')">
                                <div class="flex items-center">
                                    Product
                                    @if ($sortField === 'product_name')
                                        <span class="ml-1">{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </div>
                            </th>
                            
                            <!-- Completed Date -->
                            <th scope="col" class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Completed
                            </th>
                            
                            <!-- Technician (hidden on mobile) -->
                            <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Technician
                            </th>
                            
                            <!-- Actions -->
                            <th scope="col" class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Service Code -->
                                <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-blue-600">{{ $request->service_code }}</div>
                                </td>
                                
                                <!-- Customer -->
                                <td class="px-3 sm:px-4 md:px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->owner_name }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-[120px] sm:max-w-none">{{ $request->email }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->contact }}</div>
                                </td>
                                
                                <!-- Product (hidden on smallest screens) -->
                                <td class="hidden sm:table-cell px-4 md:px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->product_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}</div>
                                </td>
                                
                                <!-- Completed Date -->
                                <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        {{ $request->updated_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $request->updated_at->format('h:i A') }}
                                    </div>
                                </td>
                                
                                <!-- Technician (hidden on mobile) -->
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->technician->name ?? 'N/A' }}</div>
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('staff.task.show', $request->id) }}"
                                            class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            title="View Details">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span class="ml-1 hidden sm:inline">View</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No completed requests</h3>
                                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 sm:px-6 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                {{ $requests->links() }}
            </div>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center text-sm sm:text-base">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('message') }}
            </div>
        @endif
    </main>
</div>