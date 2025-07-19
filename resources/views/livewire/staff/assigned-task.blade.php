<div class="flex-1 p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Assigned Tasks</h2>
            <p class="text-gray-600">Tasks assigned to you by receptionists</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="flex space-x-2">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search tasks..." 
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                <select 
                    wire:model.live="statusFilter" 
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('service_code')">
                        Service Code
                        @if($sortField === 'service_code')
                            {!! $sortDirection === 'asc' ? '↑' : '↓' !!}
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" >
                     Problam
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $request->service_code }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $request->product_name }}</div>
                        <div class="text-sm text-gray-500">{{ $request->brand }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div>{{ $request->owner_name }}</div>
                        <div class="text-sm text-gray-500">{{ $request->contact }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($request->receptionist)
                            <div>{{ $request->receptionist->name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ $request->created_at->format('M d, Y') }}
                            </div>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $request->problem }}</div>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a wire:navigate
                            href="{{ route('staff.task.show', $request->id) }}" 
                            class="text-purple-600 hover:text-purple-900 mr-3"
                            title="View Details"
                        >
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No tasks assigned to you yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
    </div>

    @if (session('message'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
        >
            {{ session('message') }}
        </div>
    @endif
</div>