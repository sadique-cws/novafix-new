  <main class="flex-1 p-4 md:p-6 overflow-auto">
    <h2 class="text-2xl font-bold mb-6">Manage Service Request</h2>

    <table class="min-w-full bg-white">
    <thead>
    <tr class="bg-gray-50">
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Service Code</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Customer</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Product</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Status</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Actions</th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    <!-- Will be populated dynamically -->
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">SR-00123</td>
        <td class="px-6 py-4">John Smith (john@example.com)</td>
        <td class="px-6 py-4">MacBook Pro 15" (A2334)</td>
        <td class="px-6 py-4">
            <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In
                Progress</span>
        </td>
        <td class="px-6 py-4">
            <div class="flex space-x-2">
                <a href="#" class="text-primary hover:text-blue-700">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="#" class="text-secondary hover:text-green-700">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="text-danger hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </td>
    </tr>
    </tbody>
    </table>
  </main>
