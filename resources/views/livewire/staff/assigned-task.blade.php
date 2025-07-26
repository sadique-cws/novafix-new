<div class="flex-1 p-4 md:p-6">
    <!-- Header Section with Search/Filter -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Assigned Tasks</h2>
            <p class="text-gray-600 dark:text-gray-300">Tasks assigned to you by receptionists</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Search tasks..." 
                    class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
            </div>
            <select 
                wire:model.live="statusFilter" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            >
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    <!-- Tasks Table - Desktop View -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" wire:click="sortBy('service_code')">
                            <div class="flex items-center">
                                Service Code
                                @if($sortField === 'service_code')
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            Product
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            Assigned By
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                {{ $request->service_code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->product_name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->brand }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->owner_name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <a href="tel:{{ $request->contact }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                    {{ $request->contact }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($request->receptionist)
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->receptionist->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $request->created_at->format('M d, Y h:i A') }}
                                </div>
                            @else
                                <span class="text-gray-400 dark:text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($request->status == '0')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Pending
                                </span>
                            @elseif ($request->status == '25')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    In Progress
                                </span>
                            @elseif ($request->status == '50')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                    In Repair
                                </span>
                            @elseif ($request->status == '90')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Rejected
                                </span>
                            @elseif ($request->status == '100')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Completed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex space-x-3">
                                <a wire:navigate
                                    href="{{ route('staff.task.show', $request->id) }}" 
                                    class="text-purple-600 hover:text-purple-900 dark:hover:text-purple-400 transition-colors"
                                    title="View Details"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                
                                @if($request->status != '100')
                                <button 
                                    wire:click="markAsComplete({{ $request->id }})"
                                    class="text-green-600 hover:text-green-900 dark:hover:text-green-400 transition-colors"
                                    title="Mark Complete"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                <svg class="h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="text-lg font-medium mb-1">No tasks assigned</h3>
                                <p class="max-w-xs">You currently have no tasks assigned to you. Check back later!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span class="font-medium">{{ $requests->firstItem() }}</span> to <span class="font-medium">{{ $requests->lastItem() }}</span> of <span class="font-medium">{{ $requests->total() }}</span> results
            </div>
            <div>
                {{ $requests->links() }}
            </div>
        </div>
    </div>

    <!-- Tasks Cards - Mobile View -->
    <div class="md:hidden space-y-4">
        @forelse($requests as $request)
        <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800 p-4">
            <div class="flex justify-between items-start mb-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    {{ $request->service_code }}
                </span>
                
                @if ($request->status == '0')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                        Pending
                    </span>
                @elseif ($request->status == '25')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        In Progress
                    </span>
                @elseif ($request->status == '50')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                        In Repair
                    </span>
                @elseif ($request->status == '90')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        Rejected
                    </span>
                @elseif ($request->status == '100')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        Completed
                    </span>
                @endif
            </div>
            
            <div class="space-y-3">
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $request->product_name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $request->brand }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">Customer</h4>
                    <p class="text-gray-900 dark:text-white">{{ $request->owner_name }}</p>
                    <a href="tel:{{ $request->contact }}" class="text-sm text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300">
                        {{ $request->contact }}
                    </a>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">Assigned By</h4>
                    @if($request->receptionist)
                        <p class="text-gray-900 dark:text-white">{{ $request->receptionist->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $request->created_at->format('M d, Y h:i A') }}
                        </p>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                    @endif
                </div>
                
                <div class="flex justify-end space-x-3 pt-2">
                    <a wire:navigate
                        href="{{ route('staff.task.show', $request->id) }}" 
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                    >
                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View
                    </a>
                    
                    @if($request->status != '100')
                    <button 
                        wire:click="markAsComplete({{ $request->id }})"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Complete
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800 p-6 text-center">
            <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                <svg class="h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium mb-1">No tasks assigned</h3>
                <p class="max-w-xs">You currently have no tasks assigned to you. Check back later!</p>
            </div>
        </div>
        @endforelse
        
        <!-- Pagination - Mobile -->
        @if($requests->hasPages())
        <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800 p-4">
            <div class="flex flex-col items-center justify-between gap-4">
                <div class="text-sm text-gray-700 dark:text-gray-300 text-center">
                    Showing <span class="font-medium">{{ $requests->firstItem() }}</span> to <span class="font-medium">{{ $requests->lastItem() }}</span> of <span class="font-medium">{{ $requests->total() }}</span> results
                </div>
                <div class="w-full overflow-x-auto">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>