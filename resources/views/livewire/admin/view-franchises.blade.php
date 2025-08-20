<div>
    <div class="max-w-6xl mx-auto px-4 py-8">
    @if($franchise)
        <!-- Header Section -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <span class="text-blue-600 text-xl ">{{ substr($franchise->franchise_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl  text-gray-800">{{ $franchise->franchise_name }}</h1>
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
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Basic Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Contact Number</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->contact_no }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Email Address</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Date of Creation</p>
                        <p class="mt-1 text-gray-900">{{    $franchise->doc }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Account Created</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Last Updated</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->updated_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Address Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Street Address</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->street ?? 'Not specified' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">City</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->city ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">District</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->district ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">State</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->state ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Pincode</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->pincode ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Country</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->country ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>

            <!-- Financial Information Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Financial Information</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Aadhar Number</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->aadhar_no ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">PAN Number</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->pan_no ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Bank Name</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->bank_name ?? 'Not specified' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Account Number</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->account_no ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">IFSC Code</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->ifsc_code ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">System Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Record ID</p>
                        <p class="mt-1 text-gray-900">{{ $franchise->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Status</p>
                        <p class="mt-1">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($franchise->status) }}
                            </span>
                        </p>
                    </div>
                    @if($franchise->deleted_at)
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Deleted At</p>
                            <p class="mt-1 text-gray-900">{{ $franchise->deleted_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <a wire:navigate href="{{ route('admin.manage-franchises') }}" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to List
            </a>
            <a href="" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit Franchise
            </a>
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No franchise found</h3>
            <p class="mt-2 text-gray-500">The franchise you're looking for doesn't exist or has been deleted.</p>
            <div class="mt-6">
                <a href="{{ route('admin.franchises.index') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Franchises
                </a>
            </div>
        </div>
    @endif
</div>

<style>
.btn-primary {
    @apply inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors;
}
.btn-secondary {
    @apply inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors;
}
</style>
</div>