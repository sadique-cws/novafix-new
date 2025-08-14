<div class="container mx-auto  py-2">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <h2 class="text-2xl font-bold text-white mb-4 md:mb-0">Staff Management</h2>
            <div class="flex items-center space-x-3">
                <a wire:navigate href="{{ route('franchise.add.staff') }}"
                    class="flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition-all duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Add Staff
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="Search staff by name, email or phone..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150">
                </div>
                <div class="w-full md:w-auto">
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Filter by Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Staff Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition duration-150" wire:click="sortBy('name')">
                            <div class="flex items-center">
                                <span>Staff Member</span>
                                @if ($sortField === 'name')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($staffMembers as $staff)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ $staff->image ? asset('storage/' . $staff->image) : asset('images/default-avatar.png') }}" 
                                             alt="{{ $staff->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $staff->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $staff->serviceCategory->name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $staff->contact }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                {{ $staff->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                      {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{route('franchise.staff.edit',$staff->id)}}"
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50 transition duration-150"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <a wire:navigate href="{{route('franchise.view.staff',$staff->id)}}" 
                                        class="text-green-600 hover:text-green-900 p-1 rounded-md hover:bg-green-50 transition duration-150"
                                        title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <button wire:confirm='Are You Sure You want to Delete This Staff' 
                                            wire:click="delete({{ $staff->id }})"
                                            class="text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50 transition duration-150"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium">No staff members found</h3>
                                    <p class="mt-1">Add your first staff member to get started</p>
                                    <a wire:navigate href="{{ route('franchise.add.staff') }}"
                                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                                        Add Staff
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($staffMembers->hasPages())
        <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $staffMembers->firstItem() }}</span>
                        to <span class="font-medium">{{ $staffMembers->lastItem() }}</span>
                        of <span class="font-medium">{{ $staffMembers->total() }}</span> results
                    </p>
                </div>
                <div>
                    {{ $staffMembers->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>