<div>

<div class=" font-sans">
    <div class="min-h-screen">
        <!-- Navigation -->
      

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row gap-6">
             
                <!-- Main Content Area -->
                <div class="md:w-full">
                    <div class="bg-white rounded-lg shadow">
                        <!-- Header -->
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h1 class="text-xl font-semibold text-gray-800">Service Requests</h1>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> New Request
                            </button>
                        </div>

                        <!-- Filters -->
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                                <div class="flex space-x-2">
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                                            <option>All Status</option>
                                            <option>Pending</option>
                                            <option>In Progress</option>
                                            <option>Completed</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <input type="text" placeholder="Search requests..." class="w-full md:w-64 bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded leading-tight focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <button class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded flex items-center">
                                        <i class="fas fa-filter mr-2"></i> Filters
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Requests Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Code</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <td class="bg-white divide-y divide-gray-200">
                                  @foreach ($requests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->service_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->owner_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->product_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($request->status == '0')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($request->status == '50')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                            @elseif($request->status == '100')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                            @elseif($request->status == '90')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="text-blue-600 hover:text-blue-900">View</a>
                                        </td>
                                    </tr>
                                      
                                  @endforeach
                                    
                                   
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">24</span> results
                                </div>
                                <div class="flex space-x-2">
                                    <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        Previous
                                    </button>
                                    <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple Alpine.js component for demonstration
        document.addEventListener('alpine:init', () => {
            Alpine.data('serviceRequests', () => ({
                init() {
                    // In a real application, this would fetch data from the server
                    console.log('Service requests component initialized');
                }
            }));
        });
    </script>
</div>
</div>