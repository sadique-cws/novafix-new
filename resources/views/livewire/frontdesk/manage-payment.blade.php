<div class="max-w-7xl mx-auto py-8 px-4 md:px-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-blue-700 tracking-tight drop-shadow">Manage Payments</h2>
            <p class="text-lg text-gray-500 mt-1">View and manage all service payments</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-3">
            <button
                class="px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-xl shadow hover:scale-105 transition-all duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Payment
            </button>
            <button
                class="px-5 py-2 border-2 border-blue-500 text-blue-700 rounded-xl bg-white shadow hover:bg-blue-50 transition-all duration-200 flex items-center">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-blue-500 hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base font-semibold text-gray-500">Total Payments</p>
                    <p class="text-3xl font-extrabold text-blue-700 mt-1">₹0.00</p>
                </div>
                <div class="p-4 rounded-full bg-blue-100 text-blue-600 shadow">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-green-500 hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base font-semibold text-gray-500">Completed</p>
                    <p class="text-3xl font-extrabold text-green-700 mt-1">0</p>
                </div>
                <div class="p-4 rounded-full bg-green-100 text-green-600 shadow">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-yellow-500 hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-base font-semibold text-gray-500">Pending</p>
                    <p class="text-3xl font-extrabold text-yellow-700 mt-1">0</p>
                </div>
                <div class="p-4 rounded-full bg-yellow-100 text-yellow-600 shadow">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-x-auto border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Service
                        Code</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Customer
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-blue-700 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <!-- Example row, replace with dynamic data -->
              @foreach ($payments as $payment)
                    <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-700">{{$payment->service->service_code}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$payment->service->owner_name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-blue-700 font-bold">₹{{$payment->total_amount}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                       @if ($payment->status === 'completed')
                            <span class="text-green-600 font-semibold">Completed</span>
                        @elseif ($payment->status === 'pending')
                            <span class="text-yellow-600 font-semibold">Pending</span>
                        @else
                            <span class="text-red-600 font-semibold">Cancelled</span>
                           
                       @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{$payment->payment_method}}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">2025-07-22</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button
                            class="px-3 py-1 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition text-xs font-semibold">View</button>
                        <button
                            class="px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition text-xs font-semibold ml-2">Delete</button>
                    </td>
                </tr>
              @endforeach
              
            </tbody>
        </table>
    </div>
</div>
