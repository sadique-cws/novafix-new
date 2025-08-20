<div class="min-h-screen bg-gray-50">
    <main class="p-4 md:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="mb-6 md:mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl  text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 mr-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Completed Service Requests
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">View all successfully resolved service requests</p>
                </div>

                <!-- Search -->
                <div class="relative w-full md:w-1/3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search completed requests..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white shadow-sm transition-all duration-200">
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Completed -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Completed</p>
                        <h3 class="text-xl sm:text-2xl  text-gray-800 mt-1">{{ $totalCompleted }}</h3>
                    </div>
                    <div class="p-2 sm:p-3 rounded-full bg-green-50 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1 sm:mt-2">Successfully resolved requests</p>
            </div>

            <!-- This Week -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">This Week</p>
                        <h3 class="text-xl sm:text-2xl  text-gray-800 mt-1">{{ $thisWeekCount }}</h3>
                    </div>
                    <div class="p-2 sm:p-3 rounded-full bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1 sm:mt-2">Completed in last 7 days</p>
            </div>

            <!-- Top Technician -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Top Technician</p>
                        <h3 class="text-xl sm:text-2xl  text-gray-800 mt-1 truncate">
                            {{ $topTechnician->name ?? 'N/A' }}</h3>
                    </div>
                    <div class="p-2 sm:p-3 rounded-full bg-purple-50 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1 sm:mt-2">{{ $topTechnician->count ?? 0 }} completed</p>
            </div>

            <!-- Average Resolution -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Avg. Resolution</p>
                        <h3 class="text-xl sm:text-2xl  text-gray-800 mt-1">{{ $averageResolutionDays }} days
                        </h3>
                    </div>
                    <div class="p-2 sm:p-3 rounded-full bg-yellow-50 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1 sm:mt-2">Time to complete requests</p>
            </div>
        </div>

        <!-- Requests Table (Desktop/Tablet) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hidden md:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('service_code')">
                                <div class="flex items-center">
                                    <span>Request ID</span>
                                    <span class="ml-1">
                                        @if ($sortField === 'service_code')
                                            {!! $sortDirection === 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('owner_name')">
                                <div class="flex items-center">
                                    <span>Customer</span>
                                    <span class="ml-1">
                                        @if ($sortField === 'owner_name')
                                            {!! $sortDirection === 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('product_name')">
                                <div class="flex items-center">
                                    <span>Product</span>
                                    <span class="ml-1">
                                        @if ($sortField === 'product_name')
                                            {!! $sortDirection === 'asc' ? '↑' : '↓' !!}
                                        @endif
                                    </span>
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Completion Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Technician
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-green-50 rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->service_code }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $request->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->owner_name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $request->contact }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->product_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->brand }}</div>
                                    <div class="text-xs text-gray-500">SN: {{ $request->serial_no }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->updated_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $request->updated_at->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($request->technician)
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <span
                                                    class="text-indigo-600 text-sm font-medium">{{ substr($request->technician->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $request->technician->name }}</div>
                                                <div class="text-xs text-gray-500">Assigned</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('frontdesk.servicerequest.show', $request->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-150"
                                            title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No completed service
                                            requests found</h3>
                                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to
                                            find what you're looking for.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($requests->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <button wire:click="previousPage"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                    @endif

                    @if ($requests->hasMorePages())
                        <button wire:click="nextPage"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </button>
                    @else
                        <span
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $requests->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $requests->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $requests->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            @forelse($requests as $request)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-200">
                    <div class="p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-10 w-10 bg-green-50 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $request->service_code }}</h3>
                                    <p class="text-xs text-gray-500">{{ $request->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </div>

                        <div class="mt-4">
                            <div class="text-sm font-medium text-gray-900">{{ $request->owner_name }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $request->contact }}</div>
                        </div>

                        <div class="mt-3 border-t border-gray-200 pt-3">
                            <div class="text-sm font-medium text-gray-900">{{ $request->product_name }}</div>
                            <div class="text-xs text-gray-500">{{ $request->brand }} | SN: {{ $request->serial_no }}
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="text-xs font-medium text-gray-700">Completed On:</div>
                            <div class="text-sm text-gray-900">{{ $request->updated_at->format('M d, Y h:i A') }}
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            @if ($request->technician)
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span
                                            class="text-indigo-600 text-xs font-medium">{{ substr($request->technician->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-xs font-medium text-gray-900">
                                            {{ $request->technician->name }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs text-gray-500">No technician</span>
                            @endif

                            <div class="flex space-x-3">
                                <a href="{{ route('frontdesk.servicerequest.show', $request->id) }}"
                                    class="text-blue-600 hover:text-blue-800" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No completed service requests found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're
                            looking for.</p>
                    </div>
                </div>
            @endforelse

            <!-- Mobile Pagination -->
            @if ($requests->hasPages())
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 p-4">
                    <div class="flex justify-between">
                        @if ($requests->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <button wire:click="previousPage"
                                class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </button>
                        @endif

                        @if ($requests->hasMorePages())
                            <button wire:click="nextPage"
                                class="ml-3 relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </button>
                        @else
                            <span
                                class="ml-3 relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg text-sm flex items-center space-x-2 transform transition-all duration-300"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif
    </main>
</div>
