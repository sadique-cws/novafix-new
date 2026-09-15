<div class="space-y-6">
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search, Filters and Actions -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <x-ui.input type="text" wire:model.live="search" placeholder="Search by name, email or contact..." />
        </div>
        <div class="w-full md:w-auto">
            <x-ui.select wire:model.live="statusFilter">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </x-ui.select>
        </div>
        <div class="w-full md:w-auto shrink-0">
            <a wire:navigate href="{{ route('franchise.add.receptioners') }}" class="block">
                <x-ui.button class="w-full md:w-auto">
                    <i class="fas fa-plus mr-2"></i> Add Receptionist
                </x-ui.button>
            </a>
        </div>
    </div>

    <!-- Receptionist Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition duration-150" wire:click="sortBy('name')">
                    <div class="flex items-center">
                        <span>Name</span>
                        @if ($sortField === 'name')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @endif
                    </div>
                </th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Contact</th>
                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase hidden sm:table-cell cursor-pointer hover:bg-gray-100 transition duration-150" wire:click="sortBy('email')">
                    <div class="flex items-center">
                        <span>Email</span>
                        @if ($sortField === 'email')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase hidden md:table-cell cursor-pointer hover:bg-gray-100 transition duration-150" wire:click="sortBy('salary')">
                    <div class="flex items-center">
                        <span>Salary</span>
                        @if ($sortField === 'salary')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase cursor-pointer hover:bg-gray-100 transition duration-150" wire:click="sortBy('status')">
                    <div class="flex items-center">
                        <span>Status</span>
                        @if ($sortField === 'status')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                        @endif
                    </div>
                </th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
            </x-slot>

            @forelse($receptionists as $receptionist)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                                     src="https://thumbs.dreamstime.com/b/person-icon-flat-style-man-symbol-person-icon-flat-style-man-symbol-isolated-white-background-simple-people-abstract-icon-118611127.jpg" 
                                     alt="{{ $receptionist->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $receptionist->name }}</div>
                                <div class="text-sm text-gray-500 sm:hidden">{{ $receptionist->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $receptionist->contact }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700 hidden sm:table-cell">{{ $receptionist->email }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700 hidden md:table-cell">₹{{ number_format($receptionist->salary, 2) }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">
                        <x-ui.badge :color="$receptionist->status ? 'green' : 'red'">
                            {{ $receptionist->status ? 'Active' : 'Inactive' }}
                        </x-ui.badge>
                    </td>
                    <td class="px-5 py-4 text-sm text-right font-medium">
                        <div class="flex justify-end space-x-3">
                            <button wire:click="view({{ $receptionist->id }})" class="text-blue-500 hover:text-blue-700 transition" title="View">
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                            <button wire:confirm='Are you sure you want to delete this Receptionist?' wire:click="confirmDelete({{ $receptionist->id }})" class="text-red-500 hover:text-red-700 transition" title="Delete">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-user-tie text-4xl mb-4 text-gray-300"></i>
                            <h3 class="text-lg font-medium text-gray-900">No receptionists found</h3>
                            <p class="mt-1 text-sm text-gray-500">Add your first receptionist to get started</p>
                            <a wire:navigate href="{{ route('franchise.add.receptioners') }}" class="mt-4">
                                <x-ui.button>Add Receptionist</x-ui.button>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        <!-- Pagination -->
        @if($receptionists->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200">
                {{ $receptionists->links() }}
            </div>
        @endif
    </div>
</div>