<main class="flex-1 p-3 sm:p-4 md:p-6 overflow-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Manage Service Requests</h2>
    
    <!-- Filters Section -->
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row gap-3 sm:gap-4">
        <!-- Search -->
        <div class="w-full sm:w-1/2 md:w-1/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search by code, customer or product..." 
                    class="w-full pl-10 pr-4 py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
        
        <!-- Status Filter -->
        <div class="w-full sm:w-1/2 md:w-1/4">
            <select 
                wire:model.live="statusFilter" 
                class="w-full px-4 py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('service_code')">
                            <div class="flex items-center">
                                <span>Code</span>
                                <span class="ml-1">
                                    @if($sortField === 'service_code')
                                        {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('owner_name')">
                            <div class="flex items-center">
                                <span class="hidden xs:inline">Customer</span>
                                <span class="ml-1">
                                    @if($sortField === 'owner_name')
                                        {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="hidden sm:table-cell px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_name')">
                            <div class="flex items-center">
                                <span>Product</span>
                                <span class="ml-1">
                                    @if($sortField === 'product_name')
                                        {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Technician
                        </th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50">
                        <!-- Service Code -->
                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $request->service_code }}
                        </td>
                        
                        <!-- Customer -->
                        <td class="px-3 sm:px-4 md:px-6 py-4">
                            <div class="text-sm font-medium">{{ $request->owner_name }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-[120px] sm:max-w-none">{{ $request->email }}</div>
                            <div class="text-xs text-gray-500">{{ $request->contact }}</div>
                        </td>
                        
                        <!-- Product (hidden on mobile) -->
                        <td class="hidden sm:table-cell px-4 md:px-6 py-4">
                            <div class="text-sm">{{ $request->product_name }}</div>
                            <div class="text-xs text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}</div>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                            @if($request->status == 0)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Pending
                                </span>
                            @elseif($request->status == 100)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        
                        <!-- Technician (hidden on tablet) -->
                        <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-500">
                            @if($request->technician_id)
                                {{ $request->technician->name }}
                            @else
                                <select 
                                    wire:change="assignTechnician('{{ $request->id }}', $event.target.value)"
                                    class="text-xs sm:text-sm border rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                    <option value="">Assign</option>
                                    @foreach($technicians as $tech)
                                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2 sm:space-x-3">
                                <a 
                                    href="{{route('frontdesk.view.task', $request->id)}}" 
                                    class="text-blue-600 hover:text-blue-900"
                                    title="View"
                                >
                                    <i class="fas fa-eye"></i>
                                    <span class="sr-only">View</span>
                                </a>
                                <a 
                                    href="" 
                                    class="text-green-600 hover:text-green-900"
                                    title="Edit"
                                >
                                    <i class="fas fa-edit"></i>
                                    <span class="sr-only">Edit</span>
                                </a>
                                <button 
                                    wire:click="deleteRequest('{{ $request->id }}')" 
                                    class="text-red-600 hover:text-red-900"
                                    title="Delete"
                                    onclick="return confirm('Are you sure?')"
                                >
                                    <i class="fas fa-trash"></i>
                                    <span class="sr-only">Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No service requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
    </div>
    
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg text-sm sm:text-base"
        >
            {{ session('message') }}
        </div>
    @endif
</main>