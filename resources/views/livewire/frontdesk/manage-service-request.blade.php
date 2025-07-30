<main class="flex-1 p-2 sm:p-4 md:p-6 lg:p-8 overflow-auto bg-gray-100">
    <!-- Sticky Header -->
    <div class="sticky top-0 bg-gray-100 z-10 pb-2 sm:pb-4">
        <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-4 text-gray-900 flex items-center">
            <i class="fas fa-tools text-blue-600 mr-2 text-base sm:text-lg"></i> Manage Service Requests
        </h2>
        
        <!-- Filters Section -->
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mb-3 sm:mb-6">
            <!-- Search -->
            <div class="w-full sm:w-1/2 md:w-1/3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm sm:text-base"></i>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search by code, customer..." 
                        class="w-full pl-10 pr-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition-all duration-200"
                    >
                </div>
            </div>
            
            <!-- Status Filter -->
            <div class="w-full sm:w-1/2 md:w-1/4">
                <div class="relative">
                    <select 
                        wire:model.live="statusFilter" 
                        class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition-all duration-200 appearance-none"
                    >
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 text-sm"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests Table (Desktop/Tablet) -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden sm:block hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" wire:click="sortBy('service_code')">
                            <div class="flex items-center">
                                <span>Code</span>
                                <span class="ml-1">
                                    @if($sortField === 'service_code')
                                        {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" wire:click="sortBy('owner_name')">
                            <div class="flex items-center">
                                <span>Customer</span>
                                <span class="ml-1">
                                    @if($sortField === 'owner_name')
                                        {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="hidden md:table-cell px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_name')">
                            <div class="flex items-center">
                                <span>Product</span>
                                <span class="ml-1">
                                    @if($sortField === 'product_name')
                                        {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Technician
                        </th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50 transition-all duration-150">
                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $request->service_code }}
                        </td>
                        <td class="px-3 sm:px-4 md:px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">{{ $request->owner_name }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-[120px] sm:max-w-none">{{ $request->email }}</div>
                            <div class="text-xs text-gray-500">{{ $request->contact }}</div>
                        </td>
                        <td class="hidden md:table-cell px-4 md:px-6 py-4">
                            <div class="text-sm text-gray-900 truncate">{{ $request->product_name }}</div>
                            <div class="text-xs text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}</div>
                        </td>
                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap">
                            @if($request->status == 0)
                                <span class="px-2 sm:px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Pending
                                </span>
                            @elseif($request->status == 100)
                                <span class="px-2 sm:px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Completed
                                </span>
                            @else
                                <span class="px-2 sm:px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="hidden lg:table-cell px-6 py-4 text-sm text-gray-500">
                            @if($request->technician_id)
                                {{ $request->technician->name }}
                            @else
                                <select 
                                    wire:change="assignTechnician('{{ $request->id }}', $event.target.value)"
                                    class="text-xs sm:text-sm border border-gray-300 rounded px-2 sm:px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition-all duration-200"
                                >
                                    <option value="">Assign</option>
                                    @foreach($technicians as $tech)
                                        <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td class="px-3 sm:px-4 md:px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2 sm:space-x-3">
                                <a 
                                    href="{{ route('frontdesk.view.task', $request->id) }}" 
                                    class="text-blue-600 hover:text-blue-800 transform hover:scale-110 transition-all duration-150"
                                    title="View"
                                >
                                    <i class="fas fa-eye text-base sm:text-lg"></i>
                                    <span class="sr-only">View</span>
                                </a>
                                <a 
                                    href="" 
                                    class="text-green-600 hover:text-green-800 transform hover:scale-110 transition-all duration-150"
                                    title="Edit"
                                >
                                    <i class="fas fa-edit text-base sm:text-lg"></i>
                                    <span class="sr-only">Edit</span>
                                </a>
                                <button 
                                    wire:click="deleteRequest('{{ $request->id }}')" 
                                    class="text-red-600 hover:text-red-800 transform hover:scale-110 transition-all duration-150"
                                    title="Delete"
                                    onclick="return confirm('Are you sure?')"
                                >
                                    <i class="fas fa-trash text-base sm:text-lg"></i>
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
        <div class="px-3 sm:px-4 md:px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="sm:hidden space-y-3 p-2">
        @forelse($requests as $request)
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <div class="text-base font-semibold text-gray-900">{{ $request->service_code }}</div>
                    <div class="text-sm font-medium text-gray-800 truncate max-w-[160px]">{{ $request->owner_name }}</div>
                    <div class="text-xs text-gray-500 truncate max-w-[160px]">{{ $request->email }}</div>
                    <div class="text-xs text-gray-500">{{ $request->contact }}</div>
                </div>
                <div class="text-xs px-2 py-1.5 rounded-full font-semibold
                    @if($request->status == 0) bg-yellow-100 text-yellow-800 
                    @elseif($request->status == 100) bg-green-100 text-green-800 
                    @else bg-red-100 text-red-800 @endif">
                    <i class="fas 
                        @if($request->status == 0) fa-clock 
                        @elseif($request->status == 100) fa-check-circle 
                        @else fa-times-circle @endif mr-1"></i>
                    {{ $request->status == 0 ? 'Pending' : ($request->status == 100 ? 'Completed' : 'Rejected') }}
                </div>
            </div>
            <div class="text-sm mb-3">
                <div class="font-medium text-gray-800 truncate">{{ $request->product_name }}</div>
                <div class="text-xs text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}</div>
            </div>
            <div class="mb-3">
                @if($request->technician_id)
                    <div class="text-xs text-gray-600">Technician: <span class="font-medium">{{ $request->technician->name }}</span></div>
                @else
                    <select 
                        wire:change="assignTechnician('{{ $request->id }}', $event.target.value)"
                        class="text-sm border border-gray-300 rounded px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm w-full mt-2 transition-all duration-200"
                    >
                        <option value="">Assign Technician</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="flex space-x-3">
                <a 
                    href="{{ route('frontdesk.view.task', $request->id) }}" 
                    class="text-blue-600 hover:text-blue-800 transform hover:scale-110 transition-all duration-150"
                    title="View"
                >
                    <i class="fas fa-eye text-lg"></i>
                    <span class="sr-only">View</span>
                </a>
                <a 
                    href="" 
                    class="text-green-600 hover:text-green-800 transform hover:scale-110 transition-all duration-150"
                    title="Edit"
                >
                    <i class="fas fa-edit text-lg"></i>
                    <span class="sr-only">Edit</span>
                </a>
                <button 
                    wire:click="deleteRequest('{{ $request->id }}')" 
                    class="text-red-600 hover:text-red-800 transform hover:scale-110 transition-all duration-150"
                    title="Delete"
                    onclick="return confirm('Are you sure?')"
                >
                    <i class="fas fa-trash text-lg"></i>
                    <span class="sr-only">Delete</span>
                </button>
            </div>
        </div>
        @empty
        <div class="text-center text-sm text-gray-500 p-4 bg-white rounded-xl shadow-md">
            No service requests found.
        </div>
        @endforelse
    </div>
    
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-4 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg text-sm sm:text-base transform transition-all duration-300"
            x-transition:enter="transform ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transform ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
        >
            <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
        </div>
    @endif
</main>