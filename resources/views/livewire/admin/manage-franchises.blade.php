<div class="container  bg-white px-4 sm:px-6 lg:px-8 py-6">
    <div class=" overflow-hidden">
        <!-- Header -->
        <div
            class="px-4 sm:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl sm:text-2xl  text-gray-800">Franchise Management</h2>
            <div class="w-full sm:w-auto flex justify-end">
                <a wire:navigate href="{{route('admin.add-franchise')}}"
                    class="btn-primary w-full flex justify-center items-center gap-2 text-white font-semibold rounded-lg bg-blue-500 p-2 sm:w-auto text-center transition-transform duration-200 hover:scale-105">
                    <i class="fa-solid fa-plus"></i>
                    Add Franchise
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-4 flex items-center justify-between sm:px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="relative max-w-md w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input wire:model.live="search" type="text" placeholder="Search franchises..."
                    class="pl-10 pr-4 py-2.5 w-full rounded-lg border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm sm:text-base transition-all duration-200">
            </div>
            <select wire:model.live="statusFilter"
                class="px-3 sm:px-4 py-2 border rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="pending">Pending</option>
            </select>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div
                class="mx-4 sm:mx-6 mt-4 px-4 py-3 bg-green-50 text-green-700 rounded-lg border border-green-100 text-sm sm:text-base animate-slide-in">
                {{ session('message') }}
            </div>
        @endif

        <!-- Table - Mobile Cards -->
        <div class="sm:hidden p-4 space-y-4">
            @forelse ($franchises as $franchise)
                <div
                    class="bg-white p-4 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                <span
                                    class="text-white font-semibold text-base">{{ substr($franchise->franchise_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="text-base font-semibold text-gray-900">{{ $franchise->franchise_name }}</div>
                                <div class="text-xs text-gray-500">{{ $franchise->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <span
                            class="status-badge {{ $franchise->status === 'active' ? 'status-active' : ($franchise->status === 'inactive' ? 'status-inactive' : 'status-pending') }}">
                            {{ ucfirst($franchise->status) }}
                        </span>
                    </div>

                    <div class="mt-3 text-sm space-y-2">
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $franchise->contact_no }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $franchise->email }}
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3">
                        <button wire:click="edit({{ $franchise->id }})"
                            class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                        <a wire:navigate href="{{ route('admin.view-franchises', $franchise->id) }}"
                            class="text-green-600 hover:text-green-800 flex items-center text-sm font-medium transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-3 text-gray-600 text-base font-medium">No franchises found</p>
                    <p class="text-sm text-gray-500">Try adjusting your search or add a new franchise</p>
                </div>
            @endforelse
        </div>

        <!-- Table - Desktop & Tablet -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($franchises as $franchise)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <span
                                            class="text-white font-semibold text-base">{{ substr($franchise->franchise_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-base font-semibold text-gray-900">{{ $franchise->franchise_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $franchise->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $franchise->contact_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $franchise->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="status-badge {{ $franchise->status === 'active' ? 'status-active' : ($franchise->status === 'inactive' ? 'status-inactive' : 'status-pending') }}">
                                    {{ ucfirst($franchise->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <button wire:click="edit({{ $franchise->id }})"
                                        class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <a wire:navigate href="{{ route('admin.view-franchises', $franchise->id) }}"
                                        class="text-green-600 hover:text-green-800 flex items-center text-sm font-medium transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-3 text-gray-600 text-base font-medium">No franchises found</p>
                                    <p class="text-sm text-gray-500">Try adjusting your search or add a new franchise</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($franchises->hasPages())
            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $franchises->links() }}
            </div>
        @endif
    </div>
    <style>
        .btn-primary {
            @apply px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center transition-all duration-200 text-sm sm:text-base font-medium;
        }

        .status-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-semibold;
        }

        .status-active {
            @apply bg-green-100 text-green-800;
        }

        .status-inactive {
            @apply bg-red-100 text-red-800;
        }

        .status-pending {
            @apply bg-yellow-100 text-yellow-800;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        @media (min-width: 641px) and (max-width: 1023px) {
            .container {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .status-badge {
                @apply text-xs;
            }

            .btn-primary {
                @apply px-3 py-2;
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 1200px;
            }
        }
    </style>
</div>