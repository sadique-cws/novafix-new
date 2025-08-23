<div class="p-6 bg-gray-50 min-h-screen">
   <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
    <!-- Title -->
    <h1 class="text-2xl text-blue-800">Manage Customers</h1>

    <!-- Search -->
    <div class="relative w-full md:w-72">
        <input type="text" wire:model.live="search" 
               placeholder="Search by name, contact, or email"
               class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm
                      focus:outline-none focus:ring-1 focus:ring-blue-500">
        <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
    </div>
</div>


    <!-- Customers Table -->
    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-900">
            <thead class="bg-blue-800 text-white">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Owner Name</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $index => $customer)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $customer->owner_name }}</td>
                        <td class="px-4 py-3">{{ $customer->contact }}</td>
                        <td class="px-4 py-3">{{ $customer->email ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $customer->product_name }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href=""
                               class="inline-block px-3 py-1 bg-emerald-500 text-white text-xs rounded-lg hover:bg-emerald-600">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">No customers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
