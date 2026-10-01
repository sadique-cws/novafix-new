<div>
    <div class="max-w-6xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
    @if($franchise)
        <!-- Header Section -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden mb-6 sm:mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-blue-50/30 p-4 sm:p-6">
                <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
                    <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                        <div class="flex-shrink-0 h-11 w-11 sm:h-14 sm:w-14 rounded-full bg-blue-100 text-blue-700 font-bold text-lg sm:text-2xl flex items-center justify-center border border-blue-200/60 shadow-xs">
                            {{ strtoupper(substr($franchise->franchise_name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h1 class="text-base sm:text-2xl font-bold text-gray-900 leading-snug sm:leading-tight truncate sm:whitespace-normal">
                                {{ $franchise->franchise_name }}
                            </h1>
                            <div class="flex items-center text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 mr-1 text-gray-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>Created {{ $franchise->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 self-start sm:self-center">
                        <span class="px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-full text-xs sm:text-sm font-semibold shadow-2xs border
                            {{ $franchise->status === 'active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                               ($franchise->status === 'inactive' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                            {{ ucfirst($franchise->status) }}
                        </span>
                    </div>
                </div>
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