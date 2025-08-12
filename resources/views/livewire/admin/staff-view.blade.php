<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header with back button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Staff Profile</h1>
                <p class="text-sm text-gray-500 mt-1">Detailed information about the staff member</p>
            </div>
            <a wire:navigate href="" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Staff List
            </a>
        </div>

        <!-- Main card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Profile header with image -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                    @if($staff->image)
                        <div class="flex-shrink-0 h-24 w-24 sm:h-28 sm:w-28">
                            <img class="h-full w-full rounded-full object-cover ring-4 ring-white shadow" src="{{ asset('storage/'.$staff->image) }}" alt="Staff Image">
                        </div>
                    @else
                        <div class="flex-shrink-0 h-24 w-24 sm:h-28 sm:w-28 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                    <div class="text-center sm:text-left">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $staff->name }}</h2>
                        <p class="text-gray-600 flex items-center justify-center sm:justify-start mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $staff->email }}
                        </p>
                        <div class="mt-2">
                            <span class="px-3 py-1 inline-flex items-center text-sm leading-5 font-semibold rounded-full 
                                {{ $staff->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($staff->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information sections -->
            <div class="px-6 py-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div class="bg-gray-50 p-5 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Contact Number</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->contact }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Aadhar Number</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->aadhar }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">PAN Number</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->pan }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Address</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="bg-gray-50 p-5 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Professional Information</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Franchise</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->franchise->franchise_name ?? 'N/A' }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Service Category</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->serviceCategory->name ?? 'N/A' }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Salary</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">₹{{ number_format($staff->salary) }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <p class="text-sm font-medium text-gray-500 sm:col-span-1">Joined On</p>
                            <p class="text-sm text-gray-900 sm:col-span-2">{{ $staff->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
</div>