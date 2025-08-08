<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Receptionists Management</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search Input -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input 
                    type="text" 
                    id="search" 
                    wire:model.live="search" 
                    placeholder="Search by name, email or phone"
                    class="mt-1 block w-full py-2 px-2 border rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
            </div>

            <!-- Franchise Filter -->
            <div class="">
                <label for="franchiseFilter" class="block text-sm font-medium text-gray-700">Filter by Franchise</label>
                <select 
                    id="franchiseFilter" 
                    wire:model.live="franchiseFilter" 
                    class="mt-1 block w-full py-2 border px-2  rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <option value="">All Franchises</option>
                    @foreach($franchises as $franchise)
                        <option value="{{ $franchise->id }}">{{ $franchise->franchise_name }}</option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($receptionists as $receptionist)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $receptionist->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $receptionist->contact }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $receptionist->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $receptionist->franchise->franchise_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $receptionist->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $receptionist->status == '1' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a wire:navigate href="{{route('admin.Receptionst.view',$receptionist->id)}}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                               
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No receptionists found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 bg-gray-50 sm:px-6">
            {{ $receptionists->links() }}
        </div>
    </div>
</div>