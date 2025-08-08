<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Receptionist Details</h1>
        <a wire:navigate href="{{ route('admin.receptionst.management') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-sm font-medium">
            Back to Receptionists List
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $receptionist->name }}</h2>
                    <p class="text-gray-600">{{ $receptionist->email }}</p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $receptionist->status == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $receptionist->status == '1' ? 'Active' : 'Inactive' }}
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
                        <p class="mt-1 text-sm text-gray-900">{{ $receptionist->contact }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Aadhar Number</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $receptionist->aadhar }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">PAN Number</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $receptionist->pan }}</p>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Franchise</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $receptionist->franchise->franchise_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Salary</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $receptionist->salary }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $receptionist->address }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>