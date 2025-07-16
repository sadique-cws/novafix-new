<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with back button -->
    <div class="flex items-center justify-between mb-8">
        <a href="" class="flex items-center text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Franchises
        </a>
        <div class="flex space-x-3">
            <a href="" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Franchise Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <!-- Header with status -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <span class="text-blue-600 text-xl font-bold">{{ substr($franchise->franchise_name, 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $franchise->franchise_name }}</h1>
                    <div class="flex items-center text-sm text-gray-500 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        Created {{ $franchise->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium 
                {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : 
                   ($franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($franchise->status) }}
            </span>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column - Basic Info -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Basic Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->contact_no }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date of Creation</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->doc ? $franchise->doc->format('M d, Y') : 'Not specified' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Address -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Address</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Street</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->street ?? 'Not specified' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">City</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->city ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">District</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->district ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">State</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->state ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pincode</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->pincode ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Country</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->country ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information Section -->
        <div class="px-6 py-6 border-t border-gray-200">
            <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Financial Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Aadhar Number</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->aadhar_no ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">PAN Number</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->pan_no ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Bank Name</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->bank_name ?? 'Not specified' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Account Number</p>
                                <p class="mt-1 text-gray-900">{{ $franchise->account_no ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">IFSC Code</p>
                                <p class="mt-1 text-gray-900">{{ $franchise->ifsc_code ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-secondary {
    @apply px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 inline-flex items-center transition-colors;
}
</style>