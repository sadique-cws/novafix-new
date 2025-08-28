<div>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow">

            <!-- Filters -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex space-x-2">
                        <!-- Status Filter -->
                        <div class="relative">
                            <select wire:model="statusFilter"
                                class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                                <option value="">All Status</option>
                                <option value="0">Pending</option>
                                <option value="50">In Progress</option>
                                <option value="100">Completed</option>
                                <option value="90">Cancelled</option>
                            </select>
                        </div>

                        <!-- Search -->
                        <div class="relative">
                            <input type="text" wire:model="search"
                                placeholder="Search by name, email or phone..."
                                class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($requests as $request)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $request->service_code }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $request->owner_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $request->product_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($request->status == '0')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($request->status == '50')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    @elseif($request->status == '100')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                    @elseif($request->status == '90')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a wire:navigate href="{{ route('franchise.repair-request.view', $request->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">No repair requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
