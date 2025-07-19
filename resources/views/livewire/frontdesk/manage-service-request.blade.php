<main class="flex-1 p-4 md:p-6 overflow-auto">
    <h2 class="text-2xl font-bold mb-6">Manage Service Requests</h2>
    
    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="w-full md:w-1/3">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search by code, customer or product..." 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        
        <!-- Status Filter -->
        <div class="w-full md:w-1/4">
            <select 
                wire:model.live="statusFilter" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        
       
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('service_code')">
                        Service Code
                        @if($sortField === 'service_code')
                            {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('owner_name')">
                        Customer
                        @if($sortField === 'owner_name')
                            {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_name')">
                        Product
                        @if($sortField === 'product_name')
                            {!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
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
                        <div class="text-sm text-gray-500">{{ $request->brand }} | {{ $request->serial_no }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($request->status == 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Pending
                            </span>
                        @elseif($request->status == 100)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                In Progress ({{ $request->status }}%)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($request->technician_id)
                            {{ $request->technician->name }}
                        @else
                            <select 
                                wire:change="assignTechnician('{{ $request->id }}', $event.target.value)"
                                class="text-sm border rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            >
                                <option value="">Assign</option>
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <a 
                                href="" 
                                class="text-blue-600 hover:text-blue-900"
                                title="View"
                            >
                                <i class="fas fa-eye"></i>
                            </a>
                            <a 
                                href="" 
                                class="text-green-600 hover:text-green-900"
                                title="Edit"
                            >
                                <i class="fas fa-edit"></i>
                            </a>
                            <button 
                                wire:click="deleteRequest('{{ $request->id }}')" 
                                class="text-red-600 hover:text-red-900"
                                title="Delete"
                                onclick="return confirm('Are you sure?')"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No service requests found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
    </div>
    
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
        >
            {{ session('message') }}
        </div>
    @endif
</main>