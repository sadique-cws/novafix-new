<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Staff Details</h1>
        <a wire:navigate href="" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-sm font-medium">
            Back to Staff List
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                @if($staff->image)
                    <div class="flex-shrink-0 h-20 w-20">
                        <img class="h-20 w-20 rounded-full object-cover" src="{{ asset('storage/'.$staff->image) }}" alt="Staff Image">
                    </div>
                @endif
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $staff->name }}</h2>
                    <p class="text-gray-600">{{ $staff->email }}</p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $staff->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($staff->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->contact }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Aadhar Number</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->aadhar }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">PAN Number</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->pan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Franchise</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->franchise->franchise_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Service Category</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->serviceCategory->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Salary</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->salary }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Joined On</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $staff->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
</div>