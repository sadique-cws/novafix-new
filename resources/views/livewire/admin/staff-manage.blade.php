<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Staff Management</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input 
                    type="text" 
                    id="search" 
                    wire:model.live="search" 
                    placeholder="Search by name, email or phone"
                    class="mt-1 block w-full py-2 border px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
            </div>

            <!-- Franchise Filter -->
            <div>
                <label for="franchiseFilter" class="block text-sm font-medium text-gray-700">Filter by Franchise</label>
                <select 
                    id="franchiseFilter" 
                    wire:model.live="franchiseFilter" 
                    class="mt-1 block w-full py-2 border px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <option value="">All Franchises</option>
                    @foreach($franchises as $franchise)
                        <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="categoryFilter" class="block text-sm font-medium text-gray-700">Filter by Category</label>
                <select 
                    id="categoryFilter" 
                    wire:model.live="categoryFilter" 
                    class="mt-1 block py-2 w-full border px-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Franchise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($staff as $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($employee->image)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/'.$employee->image) }}" alt="">
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $employee->contact }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $employee->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $employee->franchise->franchise_name ?? 'N/A' }}
                            </td>
                           
                          
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a wire:navigate href="{{route('admin.staff.view',$employee->id)}}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No staff members found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 bg-gray-50 sm:px-6">
            {{ $staff->links() }}
        </div>
    </div>
</div>