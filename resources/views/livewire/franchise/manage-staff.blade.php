<div class="space-y-6">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search, Filters and Actions -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <x-ui.input type="text" wire:model.live="search" placeholder="Search staff by name, email or phone..." />
        </div>
        <div class="w-full md:w-auto">
            <x-ui.select>
                <option value="">Filter by Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </x-ui.select>
        </div>
        <div class="w-full md:w-auto shrink-0">
            <a wire:navigate href="{{ route('franchise.add.staff') }}" class="block">
                <x-ui.button class="w-full md:w-auto">
                    <i class="fas fa-plus mr-2"></i> Add Staff
                </x-ui.button>
            </a>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition duration-150" wire:click="sortBy('name')">
                    <div class="flex items-center">
                        <span>Staff Member</span>
                        @if ($sortField === 'name')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @endif
                    </div>
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Contact</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase hidden md:table-cell">Email</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
            </x-slot>

            @forelse($staffMembers as $staff)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                                     src="{{ $staff->image ? asset('storage/' . $staff->image) : asset('images/default-avatar.png') }}" 
                                     alt="{{ $staff->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $staff->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $staff->contact }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700 hidden md:table-cell">{{ $staff->email }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        <x-ui.badge :color="$staff->status === 'active' ? 'green' : 'red'">
                            {{ ucfirst($staff->status) }}
                        </x-ui.badge>
                    </td>
                    <td class="px-5 py-4 text-sm text-right font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{route('franchise.staff.edit',$staff->id)}}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <a wire:navigate href="{{route('franchise.view.staff',$staff->id)}}" class="text-green-500 hover:text-green-700 transition" title="View">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            <button wire:confirm='Are You Sure You want to Delete This Staff?' wire:click="delete({{ $staff->id }})" class="text-red-500 hover:text-red-700 transition" title="Delete">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                            <h3 class="text-lg font-medium text-gray-900">No staff members found</h3>
                            <p class="mt-1 text-sm text-gray-500">Add your first staff member to get started</p>
                            <a wire:navigate href="{{ route('franchise.add.staff') }}" class="mt-4">
                                <x-ui.button>Add Staff</x-ui.button>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        <!-- Pagination -->
        @if($staffMembers->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
                {{ $staffMembers->links() }}
            </div>
        @endif
    </div>
</div>