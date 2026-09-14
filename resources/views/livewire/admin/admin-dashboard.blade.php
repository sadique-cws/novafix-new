<div class="p-4 sm:p-6 lg:p-8 space-y-6">
    
    <!-- Top Stats (Made bigger with p-6 and better typography) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Total Franchises</p>
                <div class="h-8 w-8 flex items-center justify-center bg-gray-900 text-white rounded">
                    <i class="fas fa-store text-xs"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalFranchises }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Active Staff</p>
                <div class="h-8 w-8 flex items-center justify-center bg-gray-900 text-white rounded">
                    <i class="fas fa-users text-xs"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $totalstaff }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Receptionists</p>
                <div class="h-8 w-8 flex items-center justify-center bg-gray-900 text-white rounded">
                    <i class="fas fa-user-tie text-xs"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['receptionists'] }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between h-32">
            <div class="flex items-start justify-between">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Monthly Revenue</p>
                <div class="h-8 w-8 flex items-center justify-center bg-gray-900 text-white rounded">
                    <i class="fas fa-rupee-sign text-xs"></i>
                </div>
            </div>
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
            <p class="text-3xl font-bold text-gray-900">{{ $formattedRevenue }}</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Left Side: Franchise Table (Takes up 2/3 width on large screens) -->
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg">
                <!-- Header -->
                <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Manage Franchises</h2>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <x-ui.input wire:model.live="search" type="text" placeholder="Search..." icon="fas fa-search" class="w-full sm:w-56" />
                        <div class="w-full sm:w-40">
                            <x-ui.select searchable="true" wire:model.live="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </x-ui.select>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <x-ui.table>
                        <x-slot name="head">
                            <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer border-b border-gray-200 bg-gray-50/50" wire:click="sortBy('franchise_name')">
                                Franchise
                                @if ($sortField === 'franchise_name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-30"></i>
                                @endif
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Location</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer border-b border-gray-200 bg-gray-50/50" wire:click="sortBy('status')">
                                Status
                                @if ($sortField === 'status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-30"></i>
                                @endif
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Revenue</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Action</th>
                        </x-slot>

                        @forelse($franchises as $franchise)
                            <tr class="hover:bg-gray-50 border-b border-gray-100 last:border-0 transition-colors">
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded border border-gray-200 flex items-center justify-center bg-gray-100 text-gray-700 font-bold text-sm">
                                            {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $franchise->franchise_name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">ID: {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}{{ $franchise->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-800">{{ $franchise->city }}</div>
                                    <div class="text-xs text-gray-500">{{ $franchise->state }}</div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <x-ui.badge color="{{ $franchise->status === 'active' ? 'green' : ($franchise->status === 'inactive' ? 'red' : 'yellow') }}" rounded="md">
                                        {{ ucfirst($franchise->status) }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">₹{{ number_format($franchise->monthly_revenue, 2) }}</div>
                                    <div class="flex items-center gap-1 text-xs font-semibold {{ $franchise->growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-0.5">
                                        <i class="fas {{ $franchise->growth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[10px]"></i>
                                        {{ abs($franchise->growth) }}%
                                    </div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.view-franchises', $franchise->id) }}" class="text-gray-500 hover:text-gray-900 border border-gray-200 hover:bg-gray-100 rounded px-3 py-1.5 text-xs font-semibold transition-colors">View</a>
                                        <a href="{{ route('admin.edit-franchise', $franchise->id) }}" class="text-gray-500 hover:text-gray-900 border border-gray-200 hover:bg-gray-100 rounded px-3 py-1.5 text-xs font-semibold transition-colors">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500">No franchises found</td>
                            </tr>
                        @endforelse
                    </x-ui.table>
                </div>

                <!-- Mobile Layout (visible on sm and below) -->
                <div class="block md:hidden p-4 space-y-4">
                    @forelse($franchises as $franchise)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded border border-gray-200 flex items-center justify-center bg-gray-100 text-gray-700 font-bold text-sm">
                                        {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $franchise->franchise_name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">ID: {{ strtoupper(substr($franchise->franchise_name, 0, 2)) }}{{ $franchise->id }}</p>
                                    </div>
                                </div>
                                <x-ui.badge color="{{ $franchise->status === 'active' ? 'green' : ($franchise->status === 'inactive' ? 'red' : 'yellow') }}" rounded="md">
                                    {{ ucfirst($franchise->status) }}
                                </x-ui.badge>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-2 py-3 border-y border-gray-100 my-3">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Location</p>
                                    <p class="text-xs font-medium text-gray-800 mt-0.5">{{ $franchise->city }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Revenue</p>
                                    <p class="text-xs font-bold text-gray-900 mt-0.5">₹{{ number_format($franchise->monthly_revenue, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Growth</p>
                                    <p class="text-xs font-bold {{ $franchise->growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-0.5">
                                        <i class="fas {{ $franchise->growth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px]"></i> {{ abs($franchise->growth) }}%
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('admin.view-franchises', $franchise->id) }}" class="flex-1 text-center text-gray-700 border border-gray-200 bg-gray-50 hover:bg-gray-100 rounded py-2 text-xs font-semibold transition-colors">View Details</a>
                                <a href="{{ route('admin.edit-franchise', $franchise->id) }}" class="flex-1 text-center text-white border border-gray-900 bg-gray-900 hover:bg-gray-800 rounded py-2 text-xs font-semibold transition-colors">Edit</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-sm text-gray-500 border border-gray-200 rounded-md">No franchises found</div>
                    @endforelse
                </div>
                
                @if($franchises->hasPages())
                <div class="p-5 border-t border-gray-100">
                    {{ $franchises->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Extra Content to fill the page (Takes up 1/3 width) -->
        <div class="xl:col-span-1 space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-white border border-gray-200 rounded-lg">
                <div class="p-5 border-b border-gray-100">
                    <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Quick Actions</h2>
                </div>
                <div class="p-5 space-y-3">
                    <a wire:navigate href="{{ route('admin.add-franchise') }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded hover:bg-gray-50 transition-colors group">
                        <div class="h-8 w-8 rounded bg-gray-100 text-gray-600 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Add New Franchise</p>
                            <p class="text-xs text-gray-500">Register a new branch in the system</p>
                        </div>
                    </a>

                    <a wire:navigate href="{{ route('admin.staff.management') }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded hover:bg-gray-50 transition-colors group">
                        <div class="h-8 w-8 rounded bg-gray-100 text-gray-600 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                            <i class="fas fa-users-cog text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Manage Staff</p>
                            <p class="text-xs text-gray-500">View and assign roles to employees</p>
                        </div>
                    </a>

                    <a wire:navigate href="{{ route('admin.setting') }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded hover:bg-gray-50 transition-colors group">
                        <div class="h-8 w-8 rounded bg-gray-100 text-gray-600 flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors">
                            <i class="fas fa-cog text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">System Settings</p>
                            <p class="text-xs text-gray-500">Configure global application settings</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity (Placeholder) -->
            <div class="bg-white border border-gray-200 rounded-lg">
                <div class="p-5 border-b border-gray-100">
                    <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">System Status</h2>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"><i class="fas fa-circle text-[8px] text-green-500"></i></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Database Connection</p>
                                <p class="text-xs text-gray-500">Operational & Syncing</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"><i class="fas fa-circle text-[8px] text-green-500"></i></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Payment Gateway</p>
                                <p class="text-xs text-gray-500">Online & Accepting Payments</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5"><i class="fas fa-circle text-[8px] text-green-500"></i></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">SMS Services</p>
                                <p class="text-xs text-gray-500">Msg91 is fully operational</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 bg-gray-50/50 rounded-b-lg">
                    <p class="text-xs text-center text-gray-500">Last checked: Just now</p>
                </div>
            </div>

        </div>
    </div>
</div>