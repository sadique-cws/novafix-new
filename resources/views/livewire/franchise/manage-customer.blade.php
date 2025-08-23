<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-2xl text-blue-800 mb-6">Manage Customers</h1>

    <!-- Search -->
    <div class="mb-5">
        <input type="text" wire:model.live="search" 
               placeholder="Search by name, contact, or email"
               class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 
                      focus:outline-none focus:ring-2 focus:ring-blue-500">
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
