<div class="container bg-white px-4 sm:px-6 lg:px-8 py-6">
  <div class="overflow-hidden">
    <!-- Header -->
    <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <h2 class="text-xl sm:text-2xl text-gray-800">{{ $franchise->franchise_name }} - Bookings</h2>
      <div class="w-full sm:w-auto flex justify-end">
        <a wire:navigate href="{{ route('admin.manage-franchises') }}"
          class="w-full flex justify-center items-center gap-2 text-white font-semibold rounded-lg bg-gray-500 p-2 sm:w-auto text-center transition-colors duration-200 hover:bg-gray-600">
          <i class="fa-solid fa-arrow-left"></i>
          Back to Franchises
        </a>
      </div>
    </div>

    <!-- Filters -->
    <div class="px-4 flex items-center justify-between sm:px-6 py-4 bg-gray-50 border-b border-gray-100">
      <div class="relative max-w-md w-full">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <input wire:model.live="search" type="text" placeholder="Search tracking ID, customer, device..."
          class="pl-10 pr-4 py-2.5 w-full rounded-lg border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm sm:text-base transition-colors duration-200">
      </div>
    </div>

    <!-- Table - Desktop & Tablet -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
              Tracking ID
            </th>
            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
              Customer
            </th>
            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
              Device
            </th>
            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
              Amount
            </th>
            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
              Date
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse ($requests as $request)
            <tr class="hover:bg-gray-50 transition-colors duration-150">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $request->service_code }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $request->owner_name }}</div>
                <div class="text-sm text-gray-500">{{ $request->contact }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ $request->product_name }}</div>
                <div class="text-sm text-gray-500">{{ $request->brand }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ₹{{ number_format($request->payment->total_amount ?? 0, 2) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $request->created_at->format('d/m/Y h:i A') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                <div class="flex flex-col items-center justify-center py-12">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  <p class="mt-3 text-gray-600 text-base font-medium">No bookings found</p>
                  <p class="text-sm text-gray-500">This franchise doesn't have any service requests yet.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
      <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $requests->links() }}
      </div>
    @endif
  </div>
</div>
