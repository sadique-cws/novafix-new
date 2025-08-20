<div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl  text-gray-900">Receptionist Profile</h1>
                <p class="text-sm text-gray-500 mt-1">Detailed professional information</p>
            </div>
            <a wire:navigate href="{{ route('admin.receptionst.management') }}" 
               class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <!-- Main Profile Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Profile Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <!-- Profile Image Placeholder (replace with actual image if available) -->
                    <div class="flex-shrink-0 h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl  text-gray-800">{{ $receptionist->name }}</h2>
                        <div class="flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-600 text-sm">{{ $receptionist->email }}</span>
                        </div>
                        <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $receptionist->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $receptionist->status == '1' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Information Sections -->
            <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div class="space-y-5">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Personal Details</h3>
                    </div>
                    
                    <div class="space-y-4 pl-11">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $receptionist->contact }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Aadhar Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $receptionist->aadhar }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">PAN Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $receptionist->pan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="space-y-5">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-2 rounded-full mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Professional Details</h3>
                    </div>
                    
                    <div class="space-y-4 pl-11">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Franchise</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $receptionist->franchise->franchise_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</p>
                            <p class="mt-1 text-sm text-gray-900">₹{{ number_format($receptionist->salary) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Address</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $receptionist->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

         
        </div>
    </div>
</div>