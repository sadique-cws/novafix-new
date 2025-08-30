<div>
    <!-- Main content area -->
    <main class="flex-1  p-4 sm:p-6 bg-gray-50">
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Franchises -->
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Franchises</p>
                        <p class="text-xl  text-gray-800 mt-1"> {{ $totalFranchises }}</p>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class="fas fa-store text-blue-600 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Active Staff -->
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Staff</p>
                        <p class="text-xl  text-gray-800 mt-1">{{ $totalstaff }}</p>
                    </div>
                    <div class="bg-green-100 p-2 rounded-full">
                        <i class="fas fa-users text-green-600 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Receptionists -->
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Receptionists</p>
                        <p class="text-xl  text-gray-800 mt-1">{{ $stats['receptionists'] }}</p>
                    </div>
                    <div class="bg-amber-100 p-2 rounded-full">
                        <i class="fas fa-user-tie text-yellow-600 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue -->
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Revenue</p>
                        @php
                            $revenue = $stats['monthlyRevenue'];
                            $formattedRevenue = '';
                            if ($revenue >= 10000000) {
                                $formattedRevenue = '₹' . number_format($revenue / 10000000, 2) . 'Cr';
                            } elseif ($revenue >= 1000000) {
                                $formattedRevenue = '₹' . number_format($revenue / 1000000, 2) . 'M';
                            } elseif ($revenue >= 100000) {
                                $formattedRevenue = '₹' . number_format($revenue / 100000, 2) . 'L';
                            } elseif ($revenue >= 1000) {
                                $formattedRevenue = '₹' . number_format($revenue / 1000, 2) . 'k';
                            } else {
                                $formattedRevenue = '₹' . number_format($revenue, 2);
                            }
                        @endphp
                        <p class="text-xl  text-gray-800 mt-1">{{ $formattedRevenue }}</p>
                    </div>
                    <div class="bg-purple-100 p-2 rounded-full">
                        <i class="fas fa-rupee-sign text-purple-600 text-sm"></i>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Franchise List -->
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 sm:mb-6 gap-4">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800">All Franchises</h2>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <input wire:model.live="search" type="text" placeholder="Search..."
                        class="px-3 sm:px-4 py-2 border rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <select wire:model.live="statusFilter"
                        class="px-3 sm:px-4 py-2 border rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <!-- Mobile Card Layout -->
                <div class="block sm:hidden space-y-4">
                    @forelse($franchises as $franchise)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center mb-2">
                                <img class="h-8 w-8 rounded-full mr-3"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($franchise->franchise_name) }}&background=random"
                                    alt="">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $franchise->franchise_name }}</p>
                                    <p class="text-xs text-gray-500">ID:
                                        {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}{{ $franchise->id }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-900">{{ $franchise->city }}, {{ $franchise->state }}</p>
                            <p class="text-xs text-gray-500">Est. {{ $franchise->created_at->format('Y') }}</p>
                            <p class="text-xs mt-2">
                                <span
                                    class="px-2 py-1 font-semibold rounded-full 
                                        {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $franchise->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($franchise->status) }}
                                </span>
                            </p>
                            <p class="text-xs text-gray-900 mt-2">₹{{ number_format($franchise->monthly_revenue, 2) }}
                                <span class="text-gray-500">This month</span></p>
                            <p
                                class="text-xs text-{{ $franchise->growth >= 0 ? 'green' : 'red' }}-600 font-medium mt-2">
                                {{ $franchise->growth >= 0 ? '+' : '' }}{{ $franchise->growth }}%
                            </p>
                            <div class="flex gap-3 mt-3">
                                <a href="{{ route('admin.view-franchises', $franchise->id) }}"
                                    class="text-blue-600 hover:text-blue-900 text-xs">View</a>
                                <a href="{{ route('admin.edit-franchise', $franchise->id) }}"
                                    class="text-gray-600 hover:text-gray-900 text-xs">Edit</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center">No franchises found</p>
                    @endforelse
                </div>

                <!-- Desktop Table Layout -->
                <table class="min-w-full divide-y divide-gray-200 hidden sm:table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('franchise_name')">
                                Franchise
                                @if ($sortField === 'franchise_name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1"></i>
                                @endif
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Location
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                wire:click="sortBy('status')">
                                Status
                                @if ($sortField === 'status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1"></i>
                                @endif
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Revenue
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Growth
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($franchises as $franchise)
                            <tr>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 sm:h-10 w-8 sm:w-10">
                                            <img class="h-8 sm:h-10 w-8 sm:w-10 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($franchise->franchise_name) }}&background=random"
                                                alt="">
                                        </div>
                                        <div class="ml-3 sm:ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $franchise->franchise_name }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500">ID:
                                                {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}{{ $franchise->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $franchise->city }},
                                        {{ $franchise->state }}</div>
                                    <div class="text-xs text-gray-500">Est. {{ $franchise->created_at->format('Y') }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $franchise->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ ucfirst($franchise->status) }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">
                                        ₹{{ number_format($franchise->monthly_revenue, 2) }}</div>
                                    <div class="text-xs text-gray-500">This month</div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-{{ $franchise->growth >= 0 ? 'green' : 'red' }}-600 text-xs sm:text-sm font-medium">
                                        {{ $franchise->growth >= 0 ? '+' : '' }}{{ $franchise->growth }}%
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                    <a href="{{ route('admin.view-franchises', $franchise->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-2 sm:mr-3">View</a>
                                    <a href="{{ route('admin.edit-franchise', $franchise->id) }}"
                                        class="text-gray-600 hover:text-gray-900">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">
                                    No franchises found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $franchises->links() }}
            </div>
        </div>
    </main>
</div>
